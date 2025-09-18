<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;
    public $appName;
    public $currentYear;

    public function __construct($user, $verificationUrl)
    {
        $this->user = $user;
        $this->verificationUrl = $verificationUrl;
        $this->appName = config('app.name');
        $this->currentYear = date('Y');
    }

    public function build()
    {
        return $this->subject("Verify Your Email Address - {$this->appName}")
            ->from('noreply@example.com', $this->appName)
            ->html($this->buildVerificationEmail());
    }

    protected function buildVerificationEmail()
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }
        .header {
            background: #007bff;
            padding: 20px;
            text-align: center;
            color: white;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 30px;
            background: #fff;
            border: 1px solid #ddd;
            border-top: none;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-radius: 0 0 5px 5px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Verify Your Email Address</h1>
        </div>
        <div class="content">
            <h2>Hello {$this->user->name}!</h2>
            <p>Thank you for registering with {$this->appName}. Please click the button below to verify your email address.</p>

            <div style="text-align: center;">
                <a href="{$this->verificationUrl}" class="button">
                    Verify Email Address
                </a>
            </div>

            <p>If the button doesn't work, copy and paste this link into your browser:</p>
            <p style="word-break: break-all; color: #007bff;">
                <a href="{$this->verificationUrl}">{$this->verificationUrl}</a>
            </p>

            <p>If you did not create an account, no further action is required.</p>
        </div>
        <div class="footer">
            <p>This email was sent to {$this->user->email} because you registered an account with {$this->appName}.</p>
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; {$this->currentYear} {$this->appName}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
