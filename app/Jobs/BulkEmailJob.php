<?php

namespace App\Jobs;

use App\Events\MailEvent;
use App\Mail\BulkMail;
use App\Models\CampaignEmail;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BulkEmailJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $to, $subject, $body, $attachments, $campaign_id;

    /**
     * Create a new job instance.
     */
    public function __construct($to, $subject, $body, $attachments = [], $campaign_id)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->attachments = $attachments;
        $this->campaign_id = $campaign_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->to)->send(new BulkMail($this->subject, $this->body, $this->attachments ?? []));
            broadcast(new MailEvent($this->to, 'sent'));
            $this->campaign_emails_store('sent');
        } catch (Exception $e) {
            Log::info($e->getMessage());
            broadcast(new MailEvent($this->to, 'failed'));
            $this->campaign_emails_store('failed');
        }
    }
    public function campaign_emails_store($status = 'failed')
    {
        $campaign = new CampaignEmail();
        $campaign->campaign_id = $this->campaign_id;
        $campaign->email = $this->to;
        $campaign->status = $status;
        $campaign->save();
    }
}