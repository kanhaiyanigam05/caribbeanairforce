<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <title>Ticket Booking Mail</title>
    <link rel="icon" href="{{ asset($data->favicon) }}" sizes="32x32" />
    <link rel="icon" href="{{ asset($data->favicon) }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset($data->favicon) }}" />
    <style>
        body {
            font-family: "Barlow", sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        tr {
            margin: 0;
        }

        .center {
            max-width: 500px;
            margin: auto;
            background-color: #ffffff;
            border: 1px solid #0000001F;
        }

        .header img {
            width: 100%;
        }

        .summary {
            margin: 20px 0;
            text-align: left;
        }

        .summary h4 {
            font-size: 12px;
            text-transform: uppercase;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .summary li {
            padding: 10px;
            border: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
        }

        .summary li:last-child {
            font-weight: bold;
            background-color: #f3f4f6;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }

        .footer a {
            color: #BD191F;
            text-decoration: none;
            font-weight: 600;
        }

        .button {
            margin-top: 20px;
            text-align: right;
        }

        .button a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            color: #1f2937;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .button a:hover {
            background-color: #f3f4f6;
        }

        .caption {
            text-align: left;
            color: #1F2937;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 12px;
            line-height: 16px;
            margin: 0;
            margin-left: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <center class="center">
        <table>
            <tr style="display: block;">
                <td class="header" style="width: 100%; display: block;">
                    <img src="{{ $booking->event->image }}" alt="banner" draggable="false" />
                </td>
            </tr>
            <tr>
                <td style="padding: 20px; text-align: center">
                    <div
                        style="
                display: block;
                width: 72px;
                height: 72px;
                border-radius: 50%;
                border: 2px solid #e5e7eb;
                background-color: #ffffff;
                overflow: hidden;
                margin: 0 auto;
                position: relative;
                z-index: 2;
              ">
                        <img src="{{ asset($data->logo) }}" alt="logo" title="Unifying Caribbean People Socially Mentally $ Economically"
                            style="width: 100%; height: 100%; object-fit: contain" draggable="false" />
                    </div>
                    <table style="width: 100%; border-collapse: collapse; margin: 0 0 26px;">
                        <tr>
                            <td style="padding: 10px; border: none;">
                                <p style="margin: 0; color: #6b7280; font-weight: 500; font-size: 18px; line-height: 28px; text-align: start;">
                                    Event Name: <span style="font-weight: 700; color: #1f2937">{{ $booking->event->title }}</span>
                                </p>
                                <p style="font-size: 14px; line-height: 20px; color: #6b7280; font-weight: 500; margin: 0; text-align: start;">
                                    Event starts from:
                                    <span style="font-weight: 700; color: #1f2937; text-transform: capitalize">
                                        @if (isset($slots[0]['date']))
                                            {{ \Carbon\Carbon::parse($slots[0]['date'])->format('F j, Y') . ', ' . \Carbon\Carbon::parse($slots[0]['time'][0]['start_time'])->format('h:i A') }}
                                        @elseif(isset($slots[0]['start_date']))
                                            {{ \Carbon\Carbon::parse($slots[0]['start_date'])->format('F j, Y') . ', ' . \Carbon\Carbon::parse($slots[0]['time'][0]['start_time'])->format('h:i A') }}
                                        @endif
                                    </span>
                                </p>
                            </td>
                            <td style="padding: 0; border: none;">
                                <p style="font-size: 14px; line-height: 20px; color: #6b7280; margin: 0; font-weight: 500; text-align: end;">
                                    {{ $ticket ? 'Ticket' : 'Pass' }} <span style="font-weight: 700; color: #1f2937">
                                        #{{ $booking->ticket_id }}</span>
                                </p>
                                <p style="font-size: 14px; line-height: 20px; color: #6b7280; margin: 0; font-weight: 500; text-align: end;">
                                    No. of {{ $ticket ? 'Tickets' : 'Passes' }}: <span style="font-weight: 700; color: #1f2937">
                                        {{ $booking->tickets }}</span>
                                </p>
                            </td>
                        </tr>
                    </table>




                    <table>
                        @if ((float) $booking->total == 0)
                            <tr>
                                <td style="padding: 10px; text-align: left">
                                    <span
                                        style="
                      color: black;
                      text-transform: uppercase;
                      font-weight: 600;
                      font-size: 12px;
                      line-height: 16px;
                      display: block;
                    ">Booking
                                        Date :</span>
                                    <span
                                        style="
                      display: block;
                      font-weight: 500;
                      font-size: 14px;
                      line-height: 20px;
                      color: #1f2937;
                    ">{{ $booking?->created_at?->format('h:i A, M, j Y') }}</span>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td style="padding: 10px; text-align: left">
                                    <span
                                        style="
                      color: black;
                      text-transform: uppercase;
                      font-weight: 600;
                      font-size: 12px;
                      line-height: 16px;
                      display: block;
                    ">Amount
                                        paid:</span>
                                    <span
                                        style="
                      display: block;
                      font-weight: 500;
                      font-size: 14px;
                      line-height: 20px;
                      color: #1f2937;
                    ">{{ '$ ' . $booking->total }}</span>
                                </td>
                                <td style="padding: 10px; text-align: end">
                                    <span
                                        style="
                      color: black;
                      text-transform: uppercase;
                      font-weight: 600;
                      font-size: 12px;
                      line-height: 16px;
                      display: block;
                    ">Booking
                                        Date :</span>
                                    <span
                                        style="
                      display: block;
                      font-weight: 500;
                      font-size: 14px;
                      line-height: 20px;
                      color: #1f2937;
                    ">{{ $booking?->created_at?->format('h:i A, M, j Y') }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 10px; text-align: left">
                                    <span
                                        style="
                      color: black;
                      text-transform: uppercase;
                      font-weight: 600;
                      font-size: 12px;
                      line-height: 16px;
                      display: block;
                    ">Payment
                                        method:</span>
                                    <div>

                                        <svg style="width: 20px; height: 20px; font-weight: 500;
                      font-size: 14px;
                      line-height: 20px; margin-right: 3px; margin-top: 5px;"
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 48 48">
                                            <g clip-path="url(#a)">
                                                <path fill="#002991"
                                                    d="M38.914 13.35c0 5.574-5.144 12.15-12.927 12.15H18.49l-.368 2.322L16.373 39H7.056l5.605-36h15.095c5.083 0 9.082 2.833 10.555 6.77a9.687 9.687 0 0 1 .603 3.58z">
                                                </path>
                                                <path fill="#60CDFF"
                                                    d="M44.284 23.7A12.894 12.894 0 0 1 31.53 34.5h-5.206L24.157 48H14.89l1.483-9 1.75-11.178.367-2.322h7.497c7.773 0 12.927-6.576 12.927-12.15 3.825 1.974 6.055 5.963 5.37 10.35z">
                                                </path>
                                                <path fill="#008CFF"
                                                    d="M38.914 13.35C37.31 12.511 35.365 12 33.248 12h-12.64L18.49 25.5h7.497c7.773 0 12.927-6.576 12.927-12.15z">
                                                </path>
                                            </g>
                                            <defs>
                                                <clipPath id="a">
                                                    <path fill="#fff" d="M7.056 3h37.35v45H7.056z"></path>
                                                </clipPath>
                                            </defs>
                                        </svg>

                                        <span style="font-weight: 500; font-size: 14px; line-height: 20px; color: #1f2937;">{{ \App\Helpers\Setting::maskEmail($booking->email) }}</span>

                                    </div>
                                </td>
                            </tr>
                        @endif
                    </table>

                    <table style="margin-top: 40px;">
                        <tr>
                            <td colspan="2" style="color: #1F2937; text-align: left; font-size: 16px; line-height: 20px; font-weight: 600;">Summary</td>
                        </tr>
                        @php $paidAmount = 0; @endphp
                        @foreach ($booking?->slots as $slot)
                            @php $slot = (object) $slot; @endphp
                            <tr>
                                <th
                                    style="text-align: left; border-top: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 16px; line-height: 20px; font-weight: 600">
                                    @if (property_exists($slot, 'date') && $slot->date)
                                        <span>{{ \Carbon\Carbon::parse($slot->date)->format('F j, Y') }}</span>
                                    @elseif(property_exists($slot, 'start_date') && $slot->start_date)
                                        <span>{{ \Carbon\Carbon::parse($slot->start_date)->format('F j, Y') . ' - ' . \Carbon\Carbon::parse($slot->end_date)->format('F j, Y') }}</span>
                                    @endif
                                </th>
                                <th
                                    style="text-align: right; border-top: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 16px; line-height: 20px; font-weight: 600">
                                    {{ \Carbon\Carbon::parse($slot->time[0]['start_time'])->format('h:i A') . ' - ' . \Carbon\Carbon::parse($slot->time[0]['end_time'])->format('h:i A') }}
                                </th>
                            </tr>
                            @foreach ($slot->packages as $package)
                                @php
                                    $package = (object) $package;
                                    $paidAmount += $package->type === 'paid' ? (int) $package->qty * (int) $package->price : 0;
                                @endphp
                                <tr>
                                    <td
                                        style="text-align: left; border-top: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                        {{ "{$package->name} x {$package->qty}" }}
                                    </td>
                                    <td
                                        style="text-align: right; border-top: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                        {{ "$ " . (int) $package->qty * (int) $package->price }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </table>
                    <table style="margin-top: 40px;">
                        <tr>
                            <td
                                style="text-align: left; border-top: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; padding: 10px">
                                Total {{ $ticket ? 'Tickets' : 'Passes' }}</td>
                            <td
                                style="text-align: right; border-top: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                {{ $booking->tickets }}</td>
                        </tr>
                        @php $donation = number_format((int)$booking->total - $paidAmount, 2); @endphp
                        {{-- @dd($booking?->slots, $paidAmount, $booking->total, $donation) --}}
                        @if ($donation >= 0)
                            <tr>
                                <td
                                    style="text-align: left; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                    Donation
                                </td>
                                <td
                                    style="text-align: right; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                    {{ '$ ' . $donation }}</td>
                            </tr>
                        @endif
                        @if ($paidAmount >= 0)
                            <tr>
                                <td
                                    style="text-align: left; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                    Sub-Total
                                </td>
                                <td
                                    style="text-align: right; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                    {{ '$ ' . $paidAmount }}</td>
                            </tr>
                        @endif
                        @if ((int) $booking?->total >= 0)
                            <tr>
                                <td
                                    style="text-align: left; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                    Total
                                </td>
                                <td
                                    style="text-align: right; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; padding: 10px; color: #1F2937; font-size: 14px; line-height: 20px;">
                                    {{ '$ ' . $booking->total }}</td>
                            </tr>
                        @endif

                    </table>
                    @if ($booking->event->amenities->isNotEmpty())
                        <table role="presentation" style="border-collapse: collapse; width: 50%; table-layout: fixed;margin-top: 1rem;">
                            <tbody>
                                <tr>
                                    <td colspan="2" style="color: #1F2937; text-align: left; font-size: 16px; line-height: 20px; font-weight: 600;">Amenities</td>
                                </tr>
                                <tr>
                                    @foreach ($booking?->event?->amenities as $amenity)
                                        <td style="padding: 5px; text-align: center; filter: grayscale(100%);">
                                            <img src="{{ asset("uploads/amenities/{$amenity->image}") }}" title="{{ $amenity->name }}" alt="{{ $amenity->name }}"
                                                style="width: 20px; height: 20px; border-radius: 50%;">
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <div class="button">
                        <a href="{{ route('success', Crypt::encrypt($booking->id)) }}" target="_blank">View {{ $ticket ? 'Ticket' : 'Pass' }}</a>
                    </div>

                    <div class="footer">
                        <p>
                            If you have any questions, please contact us at
                            <a href="tel:{{ $data->phone }}">{{ $data->phone }}</a> or
                            <a href="mailto:{{ $data->email }}">{{ $data->email }}</a>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </center>
</body>

</html>
