<?php

namespace App\Jobs;

use App\Mail\GlobalEmailSpoolMail;
use App\Models\EmailSpool;
use App\Models\GlobalEmailSpool;
use App\Traits\HasLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GlobalEmailSpoolNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, HasLogger;

    protected $data;
    protected $emailLog;
    protected $receiver;
    protected $viewName;
    protected $document;
    protected $rejector;
    protected $isPrincipal;
    protected $attach;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $emailLog, $receiver, $viewName, $document, $rejector, $isPrincipal = null, $attach = [])
    {
        $this->data = $data;
        $this->emailLog = $emailLog;
        $this->receiver = $receiver;
        $this->viewName = $viewName;
        $this->document = $document;
        $this->rejector = $rejector;
        $this->isPrincipal = $isPrincipal;
        $this->attach = $attach;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $recipients = explode(', ', $this->emailLog->to);
            $recipientCc = !empty($this->emailLog->cc) ? explode(', ', $this->emailLog->cc) : [];
            $recipientBcc = !empty($this->emailLog->bcc) ? explode(', ', $this->emailLog->bcc) : [];

            // prepare send
            $mail = new GlobalEmailSpoolMail(
                $this->data,
                $this->emailLog,
                $this->receiver,
                $this->viewName,
                $this->document,
                $this->rejector,
                $this->isPrincipal,
                $this->attach
            );

            if(config('app.is_production') || config('mail.test')) {
                // add CC recipients
                if (!empty($recipientCc)) {
                    $mail->cc($recipientCc);
                }

                // add BCC recipients
                if (!empty($recipientBcc)) {
                    $mail->bcc($recipientBcc);
                }

                // add TO recipients
                $mail->to($recipients);
            } else {
                $mail->cc(['yan.kurniawan@metrodata.co.id']);
                $mail->bcc(['yankur01@gmail.com']);
                $mail->to([config('mail.to')]);
            }

            // send mail
            Mail::send($mail);

            $this->updateEmailLogStatus($this->emailLog);

        } catch (\Exception $ex) {
            $this->errorMessage($ex, 'email-spool', __METHOD__, $this->data->id);
            $this->handleEmailSendingFailure($this->emailLog, $ex);
        }
    }

    private function handleEmailSendingFailure($emailLog, $exception)
    {
        if ($emailLog instanceof GlobalEmailSpool) {
            // Retrieve the latest data for the email log to avoid concurrency issues
            $emailLog = $emailLog->fresh();

            // Increment the 'attempts'
            $emailLog->increment('attempt');

            // Set status email log to 'failed' and save error message
            $emailLog->update([
                'status' => GlobalEmailSpool::FAILED,
                'error_msg'  => $exception->getMessage(),
            ]);
        } else {
            $this->warningMessage('email-spool', __METHOD__, 'Invalid $emailLog provided to handleEmailSendingFailure');
        }
    }

    private function updateEmailLogStatus($emailLog)
    {
        try {
            // update status to 'sent'
            $emailLog->received_time = now();
            $emailLog->status = GlobalEmailSpool::SENT;
            $emailLog->error_msg = null;
            $emailLog->save();
        } catch (\Exception $ex) {
            $emailLog->status = GlobalEmailSpool::FAILED;
            $emailLog->save();

            $this->errorMessage($ex, 'email-spool', __METHOD__, $emailLog->id);
        }
    }
}
