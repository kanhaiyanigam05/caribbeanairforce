<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\TicketMode;
use App\Enums\Timing;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrNew(mixed $input)
 */
class Event extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'organizer_id', 'organizer_name', 'organizer_email', 'organizer_phone', 'type', 'banner', 'timing', 'start_date', 'end_date', 'venue', 'address', 'city', 'ticket_mode', 'ticket_location', 'slots', 'packages', 'reserved', 'seating_map', 'seating_plan', 'ticket_info', 'free_tickets', 'donated_tickets', 'paid_tickets', 'total_tickets', 'paid_slots', 'refund', 'description', 'status', 'meta_title', 'meta_description', 'meta_keywords', 'faqs'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'slots' => 'array',
        'passes' => 'array',
        'packages' => 'array',
        'faqs' => 'array',
        'free_tickets' => 'integer',
        'donated_tickets' => 'integer',
        'paid_tickets' => 'integer',
        'total_tickets' => 'integer',
        'ticket_mode' => TicketMode::class,
        'timing' => Timing::class,
        'status' => Status::class,
        'reserved' => 'boolean',
        'seating_plan' => 'array',
    ];


    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventImage::class, 'event_id', 'id');
    }
    public function organizer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id', 'id');
    }
    public function getImageAttribute(): ?string
    {
        $image = $this->relations['images'][0] ?? $this->images()->first();
        return $image ? asset("uploads/events/{$image->image}") : null;
    }
    public function getHeaderAttribute(): string
    {
        $image = $this->relations['images'][0] ?? $this->images()->first();
        return $this->banner ? asset("uploads/events/{$this->banner}") : asset("uploads/events/{$image->image}");
    }
    public function getPriceAttribute()
    {
        // Ensure that $this->packages is an array, even if it's null
        $packages = $this->packages ?? []; // Fallback to an empty array if null

        // Extract all prices into an array, if $packages is empty or null, it will return an empty array
        $prices = array_column($packages, 'price');

        // Find and return the lowest price, return null if no prices are available
        return $prices ? min($prices) : null;
    }
    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventBooking::class, 'event_id', 'id');
    }
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'event_amenities', 'event_id', 'amenity_id');
    }

    private function processTimeSlots($slot, $date, $nextSlot): ?object
    {
        foreach ($slot['time'] as $time) {
            $start = $date->copy()->setTimeFromTimeString($time['start_time']);
            $end = $date->copy()->setTimeFromTimeString($time['end_time']);

            if ($start->isFuture() && (!$nextSlot || $start->lessThan($nextSlot->start_time))) {
                $nextSlot = (object) [
                    'date' => Carbon::parse($date->format('Y-m-d')),
                    'start_time' => Carbon::parse($start->format('H:i:s')),
                    'end_time' => Carbon::parse($end->format('H:i:s')),
                    'packages' => $time['packages'],
                    'free_tickets' => $time['free_tickets'],
                    'donated_tickets' => $time['donated_tickets'],
                    'paid_tickets' => $time['paid_tickets'],
                    'total_tickets' => $time['total_tickets'],
                ];
            }
        }
        return $nextSlot;
    }

    public function getNextSlotAttribute(): object|null
    {
        $slots = $this->slots ?? [];
        $timing = $this->timing;
        $now = Carbon::now();

        $nextSlot = null;

        switch ($timing) {
            case Timing::SINGLE:
            case Timing::DAILY:
            case Timing::WEEKLY:
            case Timing::MONTHLY:
                foreach ($slots as $slot) {
                    $date = Carbon::parse($slot['date']);
                    $start = $date->copy()->setTimeFromTimeString($slot['time'][0]['start_time']);
                    if ($start->isFuture()) {
                        $nextSlot = (object) [
                            'date' => Carbon::parse($slot['date']),
                            'start_time' => Carbon::parse($slot['time'][0]['start_time']),
                            'end_time' => Carbon::parse($slot['time'][0]['end_time']),
                            'packages' => $slot['packages'],
                            'free_tickets' => $slot['free_tickets'],
                            'donated_tickets' => $slot['donated_tickets'],
                            'paid_tickets' => $slot['paid_tickets'],
                            'total_tickets' => $slot['total_tickets'],
                            'booked_seats' => $slot['booked_seats'] ?? [],
                        ];
                    }
                }
                break;

            case Timing::CUSTOM:
                foreach ($slots as $slot) {
                    $startDate = Carbon::parse($slot['start_date']);
                    $endDate = Carbon::parse($slot['end_date']);
                    $start = $startDate->copy()->setTimeFromTimeString($slot['time'][0]['start_time']);
                    if ($start->isFuture()) {
                        $nextSlot = (object) [
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'start_time' => Carbon::parse($slot['time'][0]['start_time']),
                            'end_time' => Carbon::parse($slot['time'][0]['end_time']),
                            'packages' => $slot['packages'],
                            'free_tickets' => $slot['free_tickets'],
                            'donated_tickets' => $slot['donated_tickets'],
                            'paid_tickets' => $slot['paid_tickets'],
                            'total_tickets' => $slot['total_tickets'],
                            'booked_seats' => $slot['booked_seats'] ?? [],
                        ];
                    }
                }
                break;
        }
        // dd($nextSlot);
        return $nextSlot;
    }
    public function getFutureSlotsAttribute(): array
    {
        $slots = $this->slots ?? [];
        // dd($slots);
        $timing = $this->timing;
        $now = Carbon::now();

        $futureSlots = [];

        foreach ($slots as $slot) {
            switch ($timing) {
                case Timing::SINGLE:
                case Timing::DAILY:
                case Timing::WEEKLY:
                case Timing::MONTHLY:
                    $date = Carbon::parse($slot['date']);

                    if ($now->lte($date)) {
                        $start = $date->copy()->setTimeFromTimeString($slot['time'][0]['start_time']);
                        if ($start->isFuture()) {
                            // Grouping times by date
                            $futureSlots[] = [
                                'date' => $date->format('Y-m-d'),
                                'time' => [
                                    [
                                        'start_time' => $slot['time'][0]['start_time'],
                                        'end_time' => $slot['time'][0]['end_time'],
                                    ],
                                ],
                                'packages' => $slot['packages'],
                                'free_tickets' => $slot['free_tickets'],
                                'donated_tickets' => $slot['donated_tickets'],
                                'paid_tickets' => $slot['paid_tickets'],
                                'total_tickets' => $slot['total_tickets'],
                                'booked_seats' => $slot['booked_seats'] ?? [],
                            ];
                        }
                    }
                    break;

                case Timing::CUSTOM:
                    $startDate = Carbon::parse($slot['start_date']);
                    $endDate = Carbon::parse($slot['end_date']);
                    if ($startDate->isToday() || $startDate->isFuture()) {
                        $start = $startDate->copy()->setTimeFromTimeString($slot['time'][0]['start_time']);
                        if ($start->isFuture()) {
                            // Grouping times by date
                            $futureSlots[] = [
                                'start_date' => $startDate->format('Y-m-d'),
                                'end_date' => $endDate->format('Y-m-d'),
                                'time' => [
                                    [
                                        'start_time' => $slot['time'][0]['start_time'],
                                        'end_time' => $slot['time'][0]['end_time'],
                                    ],
                                ],
                                'packages' => $slot['packages'],
                                'free_tickets' => $slot['free_tickets'],
                                'donated_tickets' => $slot['donated_tickets'],
                                'paid_tickets' => $slot['paid_tickets'],
                                'total_tickets' => $slot['total_tickets'],
                                'booked_seats' => $slot['booked_seats'] ?? [],
                            ];
                        }
                    }
                    break;
            }
        }

        return $futureSlots;
    }

    /*public function getFutureSlotsAttribute(): array
    {
        $slots = $this->slots ?? [];
        $timing = $this->timing;
        $now = Carbon::now();

        $futureSlots = [];

        foreach ($slots as $slot) {
            switch ($timing) {
                case Timing::SINGLE:
                    $date = Carbon::parse($slot['date']);
                    if ($date->isToday() || $date->isFuture()) {
                        foreach ($slot['time'] as $time) {
                            $start = $date->copy()->setTimeFromTimeString($time['start_time']);
                            if ($start->isFuture()) {
                                $futureSlots[] = (object)[
                                    'date' => $date->format('Y-m-d'),
                                    'start_time' => $start->format('H:i A'),
                                    'end_time' => $time['end_time'],
                                    'packages' => $time['packages'],
                                    'free_tickets' => $time['free_tickets'],
                                    'donated_tickets' => $time['donated_tickets'],
                                    'paid_tickets' => $time['paid_tickets'],
                                    'total_tickets' => $time['total_tickets'],
                                ];
                            }
                        }
                    }
                    break;

                case Timing::DAILY:
                    $startDate = Carbon::parse($slot['start_date']);
                    $endDate = Carbon::parse($slot['end_date']);
                    if ($now->lte($endDate)) {
                        // Start iterating from today or the start date, whichever is later
                        $effectiveDate = $now->lt($startDate) ? $startDate : Carbon::today();

                        while ($effectiveDate->lte($endDate)) {
                            foreach ($slot['time'] as $time) {
                                $start = $effectiveDate->copy()->setTimeFromTimeString($time['start_time']);
                                $end = $effectiveDate->copy()->setTimeFromTimeString($time['end_time']);
                                if ($start->isFuture()) {
                                    $futureSlots[] = (object)[
                                        'date' => $effectiveDate->format('Y-m-d'),
                                        'start_time' => $start->format('H:i A'),
                                        'end_time' => $end->format('H:i A'),
                                        'packages' => $time['packages'],
                                        'free_tickets' => $time['free_tickets'],
                                        'donated_tickets' => $time['donated_tickets'],
                                        'paid_tickets' => $time['paid_tickets'],
                                        'total_tickets' => $time['total_tickets'],
                                    ];
                                }
                            }
                            // Move to the next day
                            $effectiveDate->addDay();
                        }
                    }
                    break;

                case Timing::WEEKLY:
                    $startDate = Carbon::parse($slot['start_date']);
                    $endDate = Carbon::parse($slot['end_date']);
                    $day = strtolower($slot['day']); // Target day of the week (e.g., 'monday')

                    if ($now->lte($endDate)) {
                        // Determine the starting point for iteration
                        $effectiveDate = $now->lt($startDate) ? $startDate : Carbon::today();
                        $currentWeekday = strtolower($now->englishDayOfWeek);

                        // Find the next occurrence of the target weekday
                        $nextSlotDate = $currentWeekday === $day ? $effectiveDate : $now->copy()->next($day);

                        // Iterate through all weekly occurrences until the end date
                        while ($nextSlotDate->lte($endDate)) {
                            foreach ($slot['time'] as $time) {
                                $start = $nextSlotDate->copy()->setTimeFromTimeString($time['start_time']);
                                $end = $nextSlotDate->copy()->setTimeFromTimeString($time['end_time']);
                                if ($start->isFuture()) {
                                    $futureSlots[] = (object)[
                                        'date' => $nextSlotDate->format('Y-m-d'),
                                        'start_time' => $start->format('H:i A'),
                                        'end_time' => $end->format('H:i A'),
                                        'packages' => $time['packages'],
                                        'free_tickets' => $time['free_tickets'],
                                        'donated_tickets' => $time['donated_tickets'],
                                        'paid_tickets' => $time['paid_tickets'],
                                        'total_tickets' => $time['total_tickets'],
                                    ];
                                }
                            }

                            // Move to the next week's occurrence of the target day
                            $nextSlotDate->addWeek();
                        }
                    }
                    break;

                case Timing::MONTHLY:
                    $startDate = Carbon::parse($slot['start_date']);
                    $endDate = Carbon::parse($slot['end_date']);
                    $day = (int)$slot['day']; // Day of the month

                    if ($now->lte($endDate)) {
                        // Determine the starting date for iteration
                        $nextSlotDate = $now->copy()->day($day);
                        if ($nextSlotDate->lt($now)) {
                            $nextSlotDate->addMonth();
                        }

                        // Iterate through all monthly occurrences until the end date
                        while ($nextSlotDate->lte($endDate)) {
                            foreach ($slot['time'] as $time) {
                                $start = $nextSlotDate->copy()->setTimeFromTimeString($time['start_time']);
                                $end = $nextSlotDate->copy()->setTimeFromTimeString($time['end_time']);
                                if ($start->isFuture()) {
                                    $futureSlots[] = (object)[
                                        'date' => $nextSlotDate->format('Y-m-d'),
                                        'start_time' => $start->format('H:i A'),
                                        'end_time' => $end->format('H:i A'),
                                        'packages' => $time['packages'],
                                        'free_tickets' => $time['free_tickets'],
                                        'donated_tickets' => $time['donated_tickets'],
                                        'paid_tickets' => $time['paid_tickets'],
                                        'total_tickets' => $time['total_tickets'],
                                    ];
                                }
                            }

                            // Move to the next month's occurrence of the target day
                            $nextSlotDate->addMonth();
                        }
                    }
                    break;

                case Timing::CUSTOM:
                    $slotDate = Carbon::parse($slot['date']);
                    if ($slotDate->isToday() || $slotDate->isFuture()) {
                        foreach ($slot['time'] as $time) {
                            $start = $slotDate->copy()->setTimeFromTimeString($time['start_time']);
                            if ($start->isFuture()) {
                                $futureSlots[] = (object)[
                                    'date' => $slotDate->format('Y-m-d'),
                                    'start_time' => $start->format('H:i A'),
                                    'end_time' => $time['end_time'],
                                    'packages' => $time['packages'],
                                    'free_tickets' => $time['free_tickets'],
                                    'donated_tickets' => $time['donated_tickets'],
                                    'paid_tickets' => $time['paid_tickets'],
                                    'total_tickets' => $time['total_tickets'],
                                ];
                            }
                        }
                    }
                    break;
            }
        }

        return $futureSlots;
    }*/
}