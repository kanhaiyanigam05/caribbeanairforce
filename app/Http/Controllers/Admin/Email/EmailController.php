<?php

namespace App\Http\Controllers\Admin\Email;

use App\Helpers\ImageHelper;
use App\Helpers\Setting;
use App\Http\Controllers\Controller;
use App\Jobs\BulkEmailJob;
use App\Mail\BulkMail;
use App\Models\Campaign;
use App\Models\MailList;
use App\Models\MailSetting;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Session;

class EmailController extends Controller
{
    public function index()
    {
        $templates = Template::get();
        return view('admin.email.index', compact('templates'));
    }
    public function compose(string $uid = null)
    {
        if ($uid) {
            $content = Template::where('uid', $uid)->first()->content;
            $templates = Template::get();
            $lists = MailList::all();
            $users = User::all();
            return view('admin.email.compose', compact('templates', 'lists', 'users', 'content'));
        } else {
            $templates = Template::get();
            $lists = MailList::all();
            $users = User::all();
            return view('admin.email.compose', compact('templates', 'lists', 'users'));
        }
    }
    public function composeSend(Request $request)
    {
        $request->validate([
            'to' => 'required|array',
            'to.*' => 'email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'mimes:jpg,png,jpeg,webp,svg,mp4,doc,pdf,docx,xlsx|max:2028'
        ]);
        // dd($request->all());

        if (!$this->mailConfig()) {
            return response()->json(['error' => 'Mail failed! Please configure email'], 400);
        }
        $to = $request->input('to');
        $subject = $request->input('subject');
        $body = $request->input('body');
        $attachments = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                $file = ImageHelper::store($image, 'attachments');
                $attachments[] = "uploads/attachments/" . $file['filename'];
            }
        }
        // dd($attachments);
        $campaign = new Campaign();
        $campaign->user_id = Auth::id();
        $campaign->subject = $subject;
        $campaign->body = $body;
        $campaign->attachments = $attachments;
        $campaign->save();

        // Structure the attachments correctly
        $attachments = array_map(function ($attachment) {
            return [
                'file' => public_path($attachment),
                'options' => [],
            ];
        }, $attachments);
        try {
            // Prepare an array of jobs
            $jobs = collect($to)->map(function ($singleEmail) use ($subject, $body, $attachments, $campaign) {
                $data = Setting::data();
                $sender = User::find(Auth::id());
                $receiver = User::where('email', $singleEmail)->first();
                $tags = tags($data, $sender, $receiver);
                // dd($tags);
                foreach ($tags as $key => $value) {
                    $body = str_replace("[$key]", $value, $body);
                }
                return new BulkEmailJob($singleEmail, $subject, $body, $attachments, $campaign->id);
            })->toArray();
            Bus::chain($jobs)->dispatch();
            return response()->json(['success' => 'Test email sent successfully.'], 200);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['error', 'Failed to send email.'], 400);
        }
    }

    public function setting()
    {
        $user = Auth::user();
        $setting = $user->mail_setting;
        if (!$setting) {
            $setting = (object) [
                'providor' => '',
                'encryption' => '',
                'password' => ''
            ];
        }

        $setting->providor = Str::upper($setting->providor ?? '');
        $setting->encryption = Str::upper($setting->encryption ?? '');
        $setting->password = $setting->password ? Crypt::decryptString($setting->password) : '';

        return view('admin.email.setting', compact('setting'));
    }
    public function settingStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'providor' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|integer|max_digits:4',
            'encryption' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'from_name' => 'required|string|max:255',
        ]);
        // Store the email settings in the database or update the existing ones.
        $user = User::findOrFail(Auth::id());
        $setting = $user->mail_setting ?: new MailSetting();
        $setting->providor = Str::lower($request->input('providor'));
        $setting->host = $request->input('host');
        $setting->port = $request->input('port');
        $setting->encryption = Str::lower($request->input('encryption'));
        $setting->username = $request->input('username');
        $setting->password = Crypt::encryptString($request->input('password'));
        $setting->from_email = $request->input('from_email');
        $setting->from_name = $request->input('from_name');
        $user->mail_setting()->save($setting);
        Alert::toast('Email setting saved successfully', 'success');
        return redirect()->back()->with('success', 'Email setting saved successfully.');
    }
    public function testEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        if (!$this->mailConfig()) {
            // Alert::toast('Mail failed! Please configure email', 'error');
            return response()->json(['message' => 'Mail failed! Please configure email'], 400);
        }
        Log::info(Config::get('mail.mailers.smtp.password'));
        try {
            Mail::to($request->input('email'))->send(new BulkMail('Testing email setup', 'This is a test email.'));
            return response()->json(['message' => 'Test email sent successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error sending test email: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to send test email.'], 400);
        }
    }
    private function mailConfig()
    {
        $setting = Auth::user()->mail_setting;
        if (!$setting) {
            return false;
        }
        Config::set('mail.mailers.smtp.host', $setting->host);
        Config::set('mail.mailers.smtp.port', $setting->port);
        Config::set('mail.mailers.smtp.encryption', $setting->encryption);
        Config::set('mail.mailers.smtp.username', $setting->username);
        Config::set('mail.mailers.smtp.password', Crypt::decryptString($setting->password));
        Config::set('mail.from.address', $setting->from_email);
        Config::set('mail.from.name', $setting->from_name);
        return true;
    }
}