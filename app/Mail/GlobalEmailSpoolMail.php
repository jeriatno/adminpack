<?php

    namespace App\Mail;

    use App\Models\MDbPartner;
    use App\Traits\HasLogger;
    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Support\Facades\Mail;

    class GlobalEmailSpoolMail extends Mailable
    {
        use Queueable, SerializesModels, HasLogger;

        public $data;
        public $emailLog;
        public $receiver;
        public $viewName;
        public $document;
        public $rejector;
        public $isPrincipal;
        public $attach;
        public $default;

        /**
         * Create a new message instance.
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
         * Build the message.
         *
         * @return $this
         */
        public function build()
        {
            try {
                // set email address
                $emailAddress = $this->setEmailAddress();

                $email = $this->from($emailAddress['from'], $emailAddress['name'])
                    ->subject(isEnv().$this->emailLog->subject)
                    ->view($this->viewName)
                    ->with(
                        [
                            'data'           => $this->data,
                            'sender'         => $this->emailLog->sender,
                            'receiver'       => $this->receiver ?? '-',
                            'rejector_name'  => $this->rejector['name'] ?? null,
                            'rejector_email' => $this->rejector['email'] ?? null,
                            'notes'          => $this->rejector['notes'] ?? null,
                            'url'            => $this->document['url'] ?? null,
                            'is_principal'   => $this->isPrincipal ?? false,
                            'action'         => $this->emailLog->action_name
                        ]
                    );

                // attach files
                if (isset($this->attach)) {
                    foreach ($this->attach as $type => $path) {
                        if ($path) {
                            $attachmentPath = storage_path('app/public/' . $path);
                            $attachmentOptions = ['mime' => 'application/zip'];

                            if (pathinfo($path, PATHINFO_EXTENSION) != 'zip') {
                                $attachmentOptions['as'] = strtoupper($type) . '_' . $this->document['number'] . '.pdf';
                                $attachmentOptions['mime'] = 'application/pdf';
                            } else {
                                $attachmentOptions['as'] = strtoupper($type) . '_' . $this->document['number'] . '.zip';
                            }

                            $email->attach($attachmentPath, $attachmentOptions);
                        }
                    }
                }
            } catch (\Exception $ex) {
                $this->errorMessage($ex, 'email-spool', __METHOD__);
            }
        }

        public function setEmailAddress()
        {
            /*// set email conf
            if ($this->isPrincipal) {
                $name = isEnv() . config('mail.from.name2');
                $from = config('mail.from.address2');

                // Setup your gmail mailer
                $transport = new \Swift_SmtpTransport(
                    config('mail.host2'),
                    config('mail.port'),
                    config('mail.encryption'));

                $transport->setUsername(config('mail.username2'));
                $transport->setPassword(config('mail.password'));

                $mailer = new \Swift_Mailer($transport);
                // Set the mailer
                Mail::setSwiftMailer($mailer);
            } else {
                $name = isEnv() . config('mail.from.name');
                $from = config('mail.from.address');

                $this->default = Mail::getSwiftMailer();
            }*/

            if ($this->isPrincipal) {
                $name = isEnv() . config('mail.from.name2');
                $from = config('mail.from.address2');


                // Setup your gmail mailer
                $transport = new \Swift_SmtpTransport(
                    config('mail.host2'),
                    config('mail.port'),
                    config('mail.encryption'));

                $transport->setUsername(config('mail.username2'));
                $transport->setPassword(config('mail.password'));

                // Any other mailer configuration stuff needed...
                $outbound = new \Swift_Mailer($transport);

                // Set the mailer as gmail
                Mail::setSwiftMailer($outbound);
            }else {
                $name = isEnv() . config('mail.from.name');
                $from = config('mail.from.address');


                // Setup your gmail mailer
                $transport = new \Swift_SmtpTransport(
                    config('mail.host'),
                    config('mail.port'),
                    config('mail.encryption'));

                $transport->setUsername(config('mail.username'));
                $transport->setPassword(config('mail.password'));

                // Any other mailer configuration stuff needed...
                $inbound = new \Swift_Mailer($transport);

                // Set the mailer as gmail
                Mail::setSwiftMailer($inbound);
            }

            return [
                'name' => $name,
                'from' => $from
            ];
        }
    }
