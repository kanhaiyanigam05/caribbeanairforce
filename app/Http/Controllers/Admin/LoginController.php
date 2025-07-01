<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Helpers\ImageHelper;
use App\Mail\PasswordUpdate;
use Carbon\Carbon;
use App\Enums\Role;
use App\Models\User;
use App\Helpers\Setting;
use App\Mail\Registration;
use Illuminate\Support\Str;
use App\Mail\ForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\UserNotification;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon as SupportCarbon;
use App\Rules\UniqueUsernameEmail;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function storeIntendedUrl(Request $request)
    {
        session(['url.intended' => $request->input('url')]);
        return response()->json(['success' => true]);
    }
    public function login()
    {
        $data = Setting::data();
        return view('auth.login', compact('data'));
    }
    public function adminLogin()
    {
        $data = Setting::data();
        return view('auth.login', compact('data'));
    }
    public function authenticate(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255',
            'password' => 'required|min:5|max:16'
        ]);
        $login = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (Auth::attempt([$login => $request->input('login'), 'password' => $request->input('password')])) {
            if (Auth::user()->block) {
                Auth::logout();
                return response()->json(['success' => false, 'message' => 'Your account has been blocked! Please contact European Certified Team.']);
            } else {
                $redirectTo = session()->pull('url.intended', route('admin.dashboard'));
                return response()->json(['success' => true, 'message' => 'Login successful', 'redirect' => $redirectTo]);
            }
        }
        return response()->json(['success' => false, 'login' => 'Invalid credentials']);
    }
    public function signup()
    {
        $data = Setting::data();
        return view('auth.signup', compact('data'));
    }
    public function storeUser(Request $request)
    {
        // Validate request
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', new UniqueUsernameEmail()],
            'email' => ['required', 'email', 'max:255', new UniqueUsernameEmail()],
            'password' => 'required|string|min:8|max:16|confirmed',
            'g-recaptcha-response' => 'required',
        ]);
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
        if (!$response->json('success')) {
            throw ValidationException::withMessages(['recaptcha' => 'reCAPTCHA verification failed.']);
        }
    
        DB::beginTransaction();
    
        try {
            $user = new User();
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->user == 'organizer' ? Role::ORGANIZER : Role::USER;
            $user->save();
    
            // Notify other users
            $notUsers = User::where('id', '!=', $user->id)->where('role', '!=', Role::SUPERADMIN)->get();
            foreach ($notUsers as $notUser) {
                $object = [
                    'title' => $user->full_name,
                    'route' => 'admin.profile',
                    'var' => $user->username,
                    'image' => $user->profile
                ];
                $notUser->notify(new UserNotification("A new user {$user->full_name} has been joined", $object));
            }
    
            // Notify superadmins
            $adminUsers = User::where('role', Role::SUPERADMIN)->get();
            foreach ($adminUsers as $adminUser) {
                $object = [
                    'title' => $user->full_name,
                    'route' => 'admin.profile',
                    'var' => $user->username,
                    'image' => $user->profile,
                    'role' => 'superadmin',
                    'user' => $user
                ];
                $adminUser->notify(new UserNotification("A new user {$user->full_name} has been joined", $object));
            }
    
            // Send verification email
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );
            Mail::to($user->email)->send(new Registration($user, $request->password, $verificationUrl));
    
            DB::commit();
    
            Auth::login($user);
    
            return response()->json(['success' => true, 'message' => 'Registration successful'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("User registration failed: {$e->getMessage()}");
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again later.'], 400);
        }
    }

    public function documents() {
        return view('auth.documents');
    }
    public function storeDocuments(Request $request) {
//        dd($request->all());
        $request->validate([
            'company_name' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'address_proof' => 'required|string|max:255',
            'license_file' => 'required|mimes:jpg,jpeg,pdf|max:2048',
            'address_proof_file' => 'required|mimes:jpg,jpeg,pdf|max:2048',
        ]);

        $user = User::findOrFail(Auth::id());
        $user->company_name = $request->company_name;
        $user->license_number = $request->license_number;
        $user->address_proof = $request->address_proof;
        if($request->hasFile('license_file')) {
            $file = ImageHelper::store($request->license_file, 'license');
            $user->license_file = $file;
        }
        if($request->hasFile('address_proof_file')) {
            $file = ImageHelper::store($request->address_proof_file, 'address-proof');
            $user->address_proof_file = $file;
        }
        $user->save();
        $adminUsers = User::where('role', Role::SUPERADMIN)->get();
        foreach ($adminUsers as $adminUser) {
            $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'user' => $user];
            $adminUser->notify(new UserNotification("A new user {$user->full_name} uploaded documents for approval", $object));
        }
        Alert::toast('Documents uploaded successfully! Please wait for admin approval.', 'success');
        return redirect()->back();
    }
    public function documentsStatus(Request $request, string $id) {
        $user = User::findOrFail($id);
        if($request->status == 'accepted') {
            if($request->type === 'license') {
                $user->license_status = Status::ACCEPTED;
                $user->save();

                $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'user' => $user];
                $user->notify(new UserNotification("Your driver license has been approved", $object));
                return response()->json(['success' => true, 'message' => 'Document approved successfully!'], 200);
            } elseif($request->type === 'address') {
                $user->address_proof_status = Status::ACCEPTED;
                $user->save();

                $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'user' => $user];
                $user->notify(new UserNotification("Your {$user->address_proof} has been approved", $object));
                return response()->json(['success' => true, 'message' => 'Document approved successfully!'], 200);
            }
        } elseif($request->status == 'rejected') {
            if($request->type === 'license') {
                $user->license_status = Status::REJECTED;
                $user->save();

                $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'user' => $user];
                $user->notify(new UserNotification("Your driver license has been rejected", $object));
                return response()->json(['success' => true, 'message' => 'Document rejected successfully!'], 200);
            } elseif($request->type === 'address') {
                $user->address_proof_status = Status::REJECTED;
                $user->save();

                $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'user' => $user];
                $user->notify(new UserNotification("Your {$user->address_proof} has been rejected", $object));
                return response()->json(['success' => true, 'message' => 'Document rejected successfully!'], 200);
            }
        } else {
            if($request->type === 'license') {
                $user->license_status = Status::PENDING;
                $user->save();

                $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'user' => $user];
                $user->notify(new UserNotification("Your driver license has been pending", $object));
                return response()->json(['success' => true, 'message' => 'Document status changed to pending successfully!'], 200);
            } elseif($request->type === 'address') {
                $user->address_proof_status = Status::PENDING;
                $user->save();

                $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'user' => $user];
                $user->notify(new UserNotification("Your {$user->address_proof} has been pending", $object));
                return response()->json(['success' => true, 'message' => 'Document status changed to pending successfully!'], 200);
            }
        }
    }
    public function storeProfile(Request $request)
    {
        // $request->validate([
        //     'profile' => [
        //         'required',
        //         'regex:/^data:image\/(jpeg|png|jpg);base64,/',
        //         function ($attribute, $value, $fail) {
        //             $data = explode(',', $value);
        //             if (base64_decode($data[1], true) === false) {
        //                 $fail('The ' . $attribute . ' must be a valid base64 image.');
        //             }
        //             if (strlen(base64_decode($data[1])) > 2048000) {
        //                 $fail('The ' . $attribute . ' may not be greater than 2MB.');
        //             }
        //         }
        //     ],
        // ]);

        $user = User::findOrFail($request->user_id);
        $user->profiles = $request->profile;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Profile updated successfully', 'profile' => $user->profiles]);
    }
    public function storeCover(Request $request)
    {
        // $request->validate([
        //     'cover' => [
        //         'required',
        //         'regex:/^data:image\/(jpeg|png|jpg);base64,/',
        //         function ($attribute, $value, $fail) {
        //             $data = explode(',', $value);
        //             if (base64_decode($data[1], true) === false) {
        //                 $fail('The ' . $attribute . ' must be a valid base64 image.');
        //             }
        //             if (strlen(base64_decode($data[1])) > 2048000) {
        //                 $fail('The ' . $attribute . ' may not be greater than 2MB.');
        //             }
        //         }
        //     ],
        // ]);

        $user = User::findOrFail($request->user_id);
        $user->cover = $request->cover;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Profile updated successfully', 'cover' => $user->cover]);
    }
    public function storePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:8|max:16',
            'password' => 'required|min:8|max:16|confirmed',
        ]);
        // Check if the provided current password matches the user's password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'current_password' => ['The current password is incorrect.']
                ]
            ], 422);
        }
        $user = User::findOrFail(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        $adminUsers = User::where('role', Role::SUPERADMIN)->get();
        foreach ($adminUsers as $adminUser) {
            $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'role' => 'superadmin', 'user' => $user];
            $adminUser->notify(new UserNotification("{$user->full_name} has updated their password", $object));
        }
        Mail::to($user->email)->send(new PasswordUpdate($user, $request->password));
        return response()->json(['success' => true, 'message' => 'Password updated successfully']);
    }

    public function storeSetting(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
        ]);
        $user = User::findOrFail(Auth::user()->id);
        $user->city = $request->city;
        $user->address = $request->address;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Settings updated successfully']);
    }

    public function forgetPassword()
    {
        $data = Setting::data();
        return view('auth.forget', compact('data'));
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|exists:users,email',
        ]);
        try {
            $token = Str::random(60);
            $email = $request->email;
            $passwordReset = [
                'email' => $email,
                'token' => $token,
                'created_at' => Carbon::now(),
            ];
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            DB::table('password_reset_tokens')->insert($passwordReset);

            Mail::to($email)->send(new ForgetPassword($token));
            Alert::success('Success', 'Password reset link sent to your email');
            return response()->json(['success' => true, 'message' => 'Password reset link sent to your email']);
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return response()->json(['success' => false, 'email' => 'Something went wrong']);
        }
    }
    public function resetPassword($token)
    {
        $data = Setting::data();
        return view('auth.reset', compact('data', 'token'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|string|min:8|max:16|confirmed',
        ]);
        try {
            $updatePassword = DB::table('password_reset_tokens')->where(['email' => $request->email, 'token' => $request->token])->first();
            if (!$updatePassword) {
                return response()->json(['success' => false, 'email' => 'Invalid token']);
            } else {
                $user = User::where('email', $request->email)->first();
                $user->password = Hash::make($request->password);
                $user->update();
                DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

                $adminUsers = User::where('role', Role::SUPERADMIN)->get();
                foreach ($adminUsers as $adminUser) {
                    $object = ['title' => $user->full_name, 'route' => 'admin.profile', 'var' => $user->username, 'image' => $user->profile, 'role' => 'superadmin', 'user' => $user];
                    $adminUser->notify(new UserNotification("{$user->full_name} has updated their password", $object));
                }
                Mail::to($user->email)->send(new PasswordUpdate($user, $request->password));
                return response()->json(['success' => true, 'message' => 'Password updated successfully']);
            }
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json(['success' => false, 'email' => 'Something went wrong']);
        }
    }
    public function logout()
    {
        $user = Auth::user();
        $loggedout = Auth::user()->role == Role::SUPERADMIN ? 'superadmin.login' : 'admin.login';
        if(request()->ajax()) {
            Auth::logout();
            return response()->json(['success' => false, 'message' => 'You are already logged in!'], 200);
        }
        else {
            Auth::logout();
            Alert::success('Success', 'Logged out successfully!');
            return redirect()->route($loggedout);
        }
    }
}
