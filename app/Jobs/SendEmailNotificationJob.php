<?php

namespace App\Jobs;

use App\Mail\ForwardOrder\SendNotificationMail;
use App\Mail\GlobalEmailSpoolMail;
use App\Models\EmailSpool;
use App\Models\ForwardOrder\ForwardOrderEmailLog;
use App\Utils\PrincipalClaimUtil;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $dataLog, $emailLog, $emailConfig, $viewName, $module, $url)
    {
        $this->data = $data;
        $this->dataLog = $dataLog;
        $this->emailLog = $emailLog;
        $this->emailConfig = $emailConfig;
        $this->viewName = $viewName;
        $this->module = $module;
        $this->url = $url;
   }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {
            if (isset($this->emailLog)) {
                $recipients = explode(', ', $this->emailConfig->to);
                // prepare send
                $mail = new GlobalEmailSpoolMail(
                    $this->data,
                    $this->dataLog,
                    $this->emailLog,
                    $this->emailConfig,
                    $recipients,
                    $this->viewName,
                    $this->module,
                    $this->url,
                );

                // add CC recipients
                if (!empty($recipientCc)) {
                    $mail->cc($cc);
                }

                // add BCC recipients
                if (!empty($recipientBcc)) {
                    $mail->bcc($recipientBcc);
                }

                // add TO recipients
                $mail->to($recipients);

                // send mail
                Mail::send($mail);

                $this->updateEmailLogStatus($this->emailLog);
            }
            else {
                Log::warning('[EMAIL_SPOOL] - ' . __METHOD__ . ' : There is no valid email address to send from.');
            }
        } catch (\Exception $ex) {
            $this->handleEmailSendingFailure($this->emailLog, $ex);
            Log::error('[EMAIL_SPOOL] - ' . __METHOD__ . ' : ' . $ex->getMessage());

            return;
        }
    }

    private function handleEmailSendingFailure($emailLog, $exception)
    {
        if ($emailLog instanceof EmailSpool) {
            // Retrieve the latest data for the email log to avoid concurrency issues
            $emailLog = $emailLog->fresh();

            // Increment the 'attempts'
            $emailLog->increment('attempts');

            // Set status email log to 'failed' and save error message
            $emailLog->update([
                'status' => EmailSpool::FAILED,
                'error'  => $exception->getMessage(),
            ]);
        } else {
            // Handle the case where $emailLog is not an instance of a model
            Log::error('[EMAIL_SPOOL] - ' . __METHOD__ . ' : Invalid $emailLog provided to handleEmailSendingFailure');
        }
    }

    private function updateEmailLogStatus($emailLog)
    {
        try {
            // update status to 'sent'
            $emailLog->sent_at = now();
            $emailLog->status = EmailSpool::SENT;
            $emailLog->save();
        } catch (\Exception $ex) {
            Log::error('[EMAIL SPOOL] - ' . __METHOD__ . ' : ' . $ex->getMessage());
        }
    }
}
