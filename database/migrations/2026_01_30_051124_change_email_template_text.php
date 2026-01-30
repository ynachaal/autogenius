<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use Schema::hasTable to skip creation if it already exists
        if (!Schema::hasTable('email_templates')) {
            Schema::create('email_templates', function (Blueprint $table) {
                $table->id();
                $table->string('title')->unique();
                $table->string('subject')->comment('Subject line for the email')->nullable();
                $table->longText('content');
                $table->boolean('is_published')->default(false);
                $table->timestamps();
            });
        }

        $now = Carbon::now();

        // Use updateOrInsert to ensure we don't trigger "Duplicate entry" errors
        $templates = [
            [
                'title' => 'Contact Us - Admin',
                'subject' => 'New Contact Inquiry from autogenius',
                'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 20px;">
<h2 style="margin: 0; font-size: 24px; font-weight: bold;">New Contact Form Submission</h2>
</td>
</tr>
<tr>
<td style="padding: 20px; color: #333333; background-color: #ffffff; font-size: 16px;">
<p style="margin: 0 0 15px 0;">Hello <strong>Admin</strong>,</p>
<p style="margin: 0 0 15px 0;">You&rsquo;ve received a new contact inquiry from your website. Here are the details:</p>
<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eeeeee;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="padding: 10px; font-weight: bold; width: 30%; background-color: #f9fafb; border-bottom: 1px solid #eeeeee;">Name:</td>
<td style="padding: 10px; width: 70%; border-bottom: 1px solid #eeeeee;">{{name}}</td>
</tr>
<tr>
<td style="padding: 10px; font-weight: bold; width: 30%; background-color: #f9fafb; border-bottom: 1px solid #eeeeee;">Email:</td>
<td style="padding: 10px; width: 70%; border-bottom: 1px solid #eeeeee;">{{email}}</td>
</tr>
<tr>
<td style="padding: 10px; font-weight: bold; width: 30%; background-color: #f9fafb; border-bottom: 1px solid #eeeeee;">Mobile No:</td>
<td style="padding: 10px; width: 70%; border-bottom: 1px solid #eeeeee;">{{mobile_no}}</td>
</tr>
<tr>
<td style="padding: 10px; font-weight: bold; width: 30%; background-color: #f9fafb; border-bottom: 1px solid #eeeeee;">Received At:</td>
<td style="padding: 10px; width: 70%; border-bottom: 1px solid #eeeeee;">{{date}}</td>
</tr>
<tr>
<td style="padding: 10px; font-weight: bold; width: 30%; background-color: #f9fafb;">Message:</td>
<td style="padding: 10px; width: 70%;">{{message}}</td>
</tr>
</tbody>
</table>
<p style="margin: 0 0 15px 0;">Please review and respond to the client at your earliest convenience.</p>
</td>
</tr>
<tr>
<td style="background-color: #f1f3f5; color: #666666; text-align: center; padding: 15px; font-size: 14px;">
<p style="margin: 0 0 5px 0;">Sent automatically by autogenius Website</p>
<p style="margin: 0 0 5px 0;">&copy; {{year}} autogenius. All rights reserved.</p>
<p style="margin: 0;"><a style="color: #4f46e5; text-decoration: underline;" href="{{website_link}}" target="_blank" rel="noopener noreferrer">Visit our website</a></p>
</td>
</tr>
</tbody>
</table>',
            ],
            [
                'title' => 'Welcome Email',
                'subject' => 'Welcome to autogenius!',
                'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 30px;">
<h2 style="margin: 0; font-size: 28px; font-weight: bold;">Welcome to autogenius!</h2>
</td>
</tr>
<tr>
<td style="padding: 30px; color: #333333; background-color: #ffffff; font-size: 16px; line-height: 1.6;">
<p style="margin: 0 0 15px 0;">Hi <strong>{{name}}</strong>,</p>
<p style="margin: 0 0 15px 0;">We’re thrilled to have you join us! At autogenius, we are dedicated to providing you with the best tools to streamline your workflow and boost your productivity.</p>
<p style="margin: 0 0 25px 0;">To get started, we recommend exploring your dashboard and setting up your profile details.</p>
<p style="margin: 25px 0; text-align: center;">
<a style="display: inline-block; padding: 12px 28px; background-color: #4f46e5; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; font-size: 18px;" href="{{dashboard_url}}" target="_blank" rel="noopener noreferrer">Get Started Now</a>
</p>
<p style="margin: 0 0 15px 0;">If you have any questions or need a helping hand, simply reply to this email. Our support team is always here for you.</p>
<p style="margin: 30px 0 5px 0; font-weight: bold;">Best Regards,</p>
<p style="margin: 0;">The autogenius Team</p>
</td>
</tr>
<tr>
<td style="background-color: #f9fafb; color: #9ca3af; text-align: center; padding: 20px; font-size: 12px;">
<p style="margin: 0 0 5px 0;">&copy; {{year}} autogenius. All rights reserved.</p>
<p style="margin: 0;">You received this email because you signed up for an account on our website.</p>
</td>
</tr>
</tbody>
</table>',
            ],
            [
                'title' => 'Forgot Password',
                'subject' => 'Reset Your autogenius Password',
                'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 20px;">
<h2 style="margin: 0; font-size: 24px; font-weight: bold;">Password Reset Request</h2>
</td>
</tr>
<tr>
<td style="padding: 20px; color: #333333; background-color: #ffffff; font-size: 16px;">
<p style="margin: 0 0 15px 0;">Hi <strong>{{name}}</strong>,</p>
<p style="margin: 0 0 15px 0;">We received a request to reset the password for your account. Click the button below to set a new password.</p>
<p style="margin: 0 0 15px 0; font-weight: bold; color: #cc0000; text-align: center;">This link will expire in 60 minutes.</p>
<p style="margin: 25px 0; text-align: center;"><a style="display: inline-block; padding: 12px 24px; background-color: #4f46e5; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; font-size: 18px;" href="{{reset_url}}" target="_blank" rel="noopener noreferrer">Reset Your Password</a></p>
<p style="margin: 0 0 5px 0; color: #666666; font-size: 14px; text-align: center;">If the button doesn\'t work, copy and paste the URL below into your browser:</p>
<p style="margin: 0 0 25px 0; text-align: center; font-size: 14px; word-break: break-all;"><a style="color: #4f46e5; text-decoration: underline;" href="{{reset_url}}" target="_blank" rel="noopener noreferrer">{{reset_url}}</a></p>
<p style="margin: 0 0 15px 0; color: #666666;">If you didn\'t request a password reset, you can safely ignore this email. No changes were made to your account.</p>
<p style="margin: 0 0 5px 0;">&mdash; The autogenius Team</p>
</td>
</tr>
</tbody>
</table>',
            ]
        ];

        foreach ($templates as $template) {
            DB::table('email_templates')->updateOrInsert(
                ['title' => $template['title']], // Unique key
                [
                    'subject' => $template['subject'],
                    'content' => $template['content'],
                    'is_published' => 1,
                    'updated_at' => $now,
                    // created_at only applied if inserting
                    'created_at' => $now, 
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Careful: Only drop if you truly want to wipe the data
        Schema::dropIfExists('email_templates');
    }
};