<?php

use App\Enums\Role;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SocialLoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('')->as('admin.')->middleware('guest')->group(function () {
    Route::get('auth/{provider}', [SocialLoginController::class, 'redirectToProvider'])->name('social.login');
    Route::get('auth/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback']);

    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate'])->name('authenticate');
    Route::get('forget-password', [LoginController::class, 'forgetPassword'])->name('forget.password');
    Route::post('forget-password', [LoginController::class, 'sendResetLink'])->name('send.reset.link');
    Route::get('reset-password/{token}', [LoginController::class, 'resetPassword'])->name('reset.password');
    Route::post('reset-password', [LoginController::class, 'updatePassword'])->name('update.password');
    Route::prefix('signup')->as('signup.')->group(function () {
        Route::get('/', [LoginController::class, 'signup'])->name('index');
        Route::post('/', [LoginController::class, 'storeUser'])->name('store.user');
    });
});
Route::prefix('admin')->as('superadmin.')->middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'adminLogin'])->name('login');
});


Route::prefix('')->as('admin.')->middleware('auth', 'role.redirect')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::prefix('signup')->as('signup.')->middleware('verified', 'verify.documents')->group(function () {
        Route::get('/documents', [LoginController::class, 'documents'])->name('documents');
        Route::post('/documents', [LoginController::class, 'storeDocuments'])->name('store.documents');
        Route::put('documents/{id}/status', [LoginController::class, 'documentsStatus'])->name('documents.status');
        Route::post('profile', [LoginController::class, 'storeProfile'])->name('store.profile');
        Route::post('cover', [LoginController::class, 'storeCover'])->name('store.cover');
        Route::post('password', [LoginController::class, 'storePassword'])->name('store.password');
        Route::post('setting', [LoginController::class, 'storeSetting'])->name('store.setting');
    });
});

Route::get('/admin/email/verify/{id}/{hash}', function ($id, $hash) {
    if(Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    else {
        return redirect()->route('verification.verify', ['id' => $id, 'hash' => $hash]);
    }
});
Route::prefix('')->middleware('auth', 'role.redirect')->group(function() {
    Route::get('/email/verify', function () {
        if (Auth::user()->hasVerifiedEmail()) {
            $redirectTo = session()->pull('url.intended', route('admin.dashboard'));
            return redirect($redirectTo);
        }
        else {
            return view('auth.verify-email');
        }
    })->name('verification.notice');

    // Handle Email Verification
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        if(Auth::check() && Auth::user()->role == \App\Enums\Role::SUPERADMIN) {
            return redirect()->route('admin.dashboard');
        }
        else {
            $request->fulfill();
            return redirect()->route('admin.dashboard');
        }
    })->middleware(['signed'])->name('verification.verify');

    // Resend Email Verification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});




Route::prefix('admin')->as('admin.')->middleware('auth', 'role.redirect')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::prefix('signup')->as('signup.')->middleware('verified', 'verify.documents')->group(function () {
        Route::get('/documents', [LoginController::class, 'documents'])->name('documents');
        Route::post('/documents', [LoginController::class, 'storeDocuments'])->name('store.documents');
        Route::put('documents/{id}/status', [LoginController::class, 'documentsStatus'])->name('documents.status');
        Route::post('profile', [LoginController::class, 'storeProfile'])->name('store.profile');
        Route::post('cover', [LoginController::class, 'storeCover'])->name('store.cover');
        Route::post('password', [LoginController::class, 'storePassword'])->name('store.password');
        Route::post('setting', [LoginController::class, 'storeSetting'])->name('store.setting');
    });
});

/*Route::prefix('admin')->middleware('auth', 'role.redirect')->group(function() {
    Route::get('/email/verify', function () {
        if (Auth::user()->hasVerifiedEmail()) {
            $redirectTo = session()->pull('url.intended', route('admin.dashboard'));
            return redirect($redirectTo);
        }
        else {
            return view('auth.verify-email');
        }
    })->name('verification.notice');

    // Handle Email Verification
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('admin.dashboard');
    })->middleware(['signed'])->name('verification.verify');

    // Resend Email Verification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});*/