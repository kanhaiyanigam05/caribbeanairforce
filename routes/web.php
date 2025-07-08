<?php

use App\Enums\Role;
use App\Events\CsrfUpdate;
use App\Events\MailFailedEvent;
use App\Events\MailSentEvent;
use App\Http\Controllers\Admin\Email\TemplateController;
use App\Http\Controllers\Admin\Email\EmailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Email\MailListController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MembershipPaypalController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\TicketController;
use App\Jobs\CsrfJob;
use App\Models\Amenity;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;


/*Route::get('/refresh-csrf', function () {
    $newToken = csrf_token();
    // broadcast(new CsrfUpdate($newToken));
    CsrfJob::dispatch();
    return response()->json(['csrf_token' => $newToken]);
});*/
Route::post('/store-intended-url', [\App\Http\Controllers\Admin\LoginController::class, 'storeIntendedUrl'])->name('store.intended.url');
Route::post('/set-timezone', function (Request $request) {
    $timezone = $request->input('timezone');
    session()->put('user_timezone', $timezone);
    date_default_timezone_set($timezone);
    config(['app.timezone' => $timezone]);

    return response()->json([
        'timezone' => $timezone,
        'serverTime' => \Carbon\Carbon::now()->toDateTimeString(),
    ]);
})->name('set.timezone');






Route::redirect('admin', 'admin/dashboard', 301);
Route::prefix('')->as('admin.')->middleware('auth', 'verified', 'verify.documents', 'role.redirect')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('notifications', [DashboardController::class, 'notifications'])->name('notifications');
    Route::post('search', [DashboardController::class, 'search'])->name('search');
    Route::get('{username}/profile', [DashboardController::class, 'profile'])->name('profile')->withoutMiddleware('verify.documents');

    Route::get('suggestions', [DashboardController::class, 'suggestions'])->name('suggestions');
    Route::get('followers', [DashboardController::class, 'followers'])->name('followers');
    Route::get('following', [DashboardController::class, 'following'])->name('following');
    Route::post('follow/{id}', [DashboardController::class, 'follow'])->name('follow');
    Route::post('unfollow/{id}', [DashboardController::class, 'unfollow'])->name('unfollow');
    Route::get('events/upcoming', [EventController::class, 'upcoming'])->name('events.upcoming');
    Route::get('events/past', [EventController::class, 'past'])->name('events.past');
    Route::put('events/{id}/status', [EventController::class, 'status'])->name('events.status');
    Route::delete('events/{id}/image', [EventController::class, 'destroyImage'])->name('events.destroy.image');

    Route::get('all-users', [UserController::class, 'allUsers'])->name('all.users');
    Route::post('search-users', [UserController::class, 'searchUsers'])->name('user.search');
    Route::get('all-events', [UserController::class, 'allEvents'])->name('all.events');
    Route::get('pending-events', [UserController::class, 'pendingEvents'])->name('pending.events');
    Route::get('accepted-events', [UserController::class, 'acceptedEvents'])->name('accepted.events');
    Route::get('rejected-events', [UserController::class, 'rejectedEvents'])->name('rejected.events');
    Route::put('users/{id}/role', [UserController::class, 'role'])->name('users.role');
    Route::put('users/{id}/block', [UserController::class, 'block'])->name('users.block');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    //    Route::get('{slug}', [EventController::class, 'show'])->where('slug', '[a-zA-Z0-9\-]+')->name('events.show');
});


Route::prefix('admin')->as('admin.')->middleware('auth', 'verified', 'verify.documents', 'role.redirect')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('notifications', [DashboardController::class, 'notifications'])->name('notifications');
    Route::post('search', [DashboardController::class, 'search'])->name('search');
    Route::get('{username}/profile', [DashboardController::class, 'profile'])->name('profile')->withoutMiddleware('verify.documents');

    Route::get('suggestions', [DashboardController::class, 'suggestions'])->name('suggestions');
    Route::get('followers', [DashboardController::class, 'followers'])->name('followers');
    Route::get('following', [DashboardController::class, 'following'])->name('following');
    Route::post('follow/{id}', [DashboardController::class, 'follow'])->name('follow');
    Route::post('unfollow/{id}', [DashboardController::class, 'unfollow'])->name('unfollow');
    Route::get('events/upcoming', [EventController::class, 'upcoming'])->name('events.upcoming');
    Route::get('events/past', [EventController::class, 'past'])->name('events.past');
    Route::put('events/{id}/status', [EventController::class, 'status'])->name('events.status');
    Route::delete('events/{id}/image', [EventController::class, 'destroyImage'])->name('events.destroy.image');

    Route::get('all-users', [UserController::class, 'allUsers'])->name('all.users');
    Route::post('search-users', [UserController::class, 'searchUsers'])->name('user.search');
    Route::get('all-events', [UserController::class, 'allEvents'])->name('all.events');
    Route::get('pending-events', [UserController::class, 'pendingEvents'])->name('pending.events');
    Route::get('accepted-events', [UserController::class, 'acceptedEvents'])->name('accepted.events');
    Route::get('rejected-events', [UserController::class, 'rejectedEvents'])->name('rejected.events');
    Route::put('users/{id}/role', [UserController::class, 'role'])->name('users.role');
    Route::put('users/{id}/block', [UserController::class, 'block'])->name('users.block');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('users/{id}/membership', [UserController::class, 'membership'])->name('users.membership');
    Route::resource('membership', MembershipController::class);
    Route::prefix('email')->as('email.')->group(function () {
        Route::get('/', [EmailController::class, 'index'])->name('index');
        Route::resource('templates', TemplateController::class)->except('update');
        Route::post('templates/{id}/edit', [TemplateController::class, 'update'])->name('templates.update');
        Route::get('templates/{uid}/builder/edit/content', [TemplateController::class, 'builderEditContent'])->name('templates.builder.edit.content');
        Route::post('templates/{uid}/builder/edit/asset', [TemplateController::class, 'uploadTemplateAssets'])->name('templates.builder.edit.asset');
        Route::get('admin/templates/rss/parse', [TemplateController::class, 'parseRss'])->name('templates.parserss');
        Route::get('assets/{dirname}/{basename}', [
            function ($dirname, $basename) {
                $dirname = base64_decode(str_replace(['-', '_'], ['+', '/'], $dirname));
                $absPath = storage_path(join_paths($dirname, $basename));

                if (File::exists($absPath)) {
                    $mimetype = getFileType($absPath);
                    return response()->file($absPath, ['Content-Type' => $mimetype]);
                } else {
                    abort(404);
                }
            }
        ])->name('public_assets');
        Route::put('templates/{uid}/thumbnail', [TemplateController::class, 'templatesThumbnail'])->name('templates.thumbnail');
        Route::put('templates/{uid}/change-name', [TemplateController::class, 'changeName'])->name('templates.change.name');
        Route::resource('lists', MailListController::class);
        Route::get('compose/{uid?}', [EmailController::class, 'compose'])->name('compose');
        Route::post('compose', [EmailController::class, 'composeSend'])->name('compose.send');
        Route::get('setting', [EmailController::class, 'setting'])->name('setting');
        Route::post('setting', [EmailController::class, 'settingStore'])->name('setting.store');
        Route::post('test-email', [EmailController::class, 'testEmail'])->name('test.email');
    });
});
Route::prefix('')->as('admin.')->middleware('auth', 'verified', 'verify.documents', 'role.redirect')->group(function () {
    Route::resource('events', EventController::class);
});
Route::prefix('admin')->as('admin.')->middleware('auth', 'verified', 'verify.documents', 'role.redirect')->group(function () {
    Route::resource('events', EventController::class);
});



require __DIR__ . '/auth.php';

Route::post('paypal/form', [PaypalController::class, 'index'])->name('paypal.form');
Route::get('paypal/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment.cancel');

Route::post('download-ticket/{id}', [MainController::class, 'downloadTicket'])->name('download.ticket');
Route::get('qr-code/{slug}/download', [MainController::class, 'downloadQRCode'])->name('download.qr.code');
Route::get('success/{id}', [MainController::class, 'success'])->name('success');

Route::get('cities', function () {
    $cities = Event::whereNotNull('city')->where('city', '!=', '')->where('status', \App\Enums\Status::ACCEPTED)->distinct()->pluck('city');
    if(!$cities) {
        return response()->json(['message' => 'Cities not found'], 400);
    }
    return response()->json($cities, 200);
});
Route::get('amenities', function () {
    $amenities = Amenity::where('type', 'static')->get();
    if($amenities) {
        return response()->json($amenities, 200);
    }
    return response()->json(['message' => 'Amenities not found'], 400);
});

Route::get('intellectual-property-rights-policy', [MainController::class, 'intellectualPolicy'])->name('intellectual.policy');
Route::get('privacy-policy', [MainController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('terms-and-conditions', [MainController::class, 'termsPolicy'])->name('terms.policy');
Route::get('faqs', [MainController::class, 'faqs'])->name('faqs');
Route::get('faqs-online-radio-station', [MainController::class, 'faqsRadio'])->name('faqs.radio');



Route::get('seating-plan/{uuid}', [TicketController::class, 'seatingPlan'])->name('seating.plan');
Route::get('ticket-booking/{slug}', [TicketController::class, 'ticketBooking'])->name('ticket.booking');

Route::prefix('membership')->as('membership.')->group(function () {
    Route::get('plans', [MembershipPaypalController::class, 'plans'])->name('plans');
    Route::get('checkout/{slug}', [MembershipPaypalController::class, 'checkout'])->name('checkout');
    Route::post('checkout/{slug}', [MembershipPaypalController::class, 'checkoutProcess'])->name('checkout.process');
    Route::get('payment/success', [MembershipPaypalController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment/cancel', [MembershipPaypalController::class, 'paymentCancel'])->name('payment.cancel');
    Route::get('success/{id}', [MembershipPaypalController::class, 'success'])->name('success');
});


Route::post('/load-more-events', [MainController::class, 'loadMoreEvents'])->name('load.more.events');
Route::get('/{city?}', [MainController::class, 'events'])->name('events.index');
// Route::get('/{slug}', [MainController::class, 'eventDetail'])->where('slug', '[a-zA-Z0-9\-]+')->name('event.detail');
