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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('subject')->comment('Subject line for the email')->nullable();
            $table->longText('content');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        // Insert Contact Us and Forgot Password templates for Autogenious
        DB::table('email_templates')->insert([
            [
                'title' => 'Contact Us - Admin',
                'subject' => 'New Contact Inquiry from Autogenious',
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
<p style="margin: 0 0 5px 0;">Sent automatically by Autogenious Website</p>
<p style="margin: 0 0 5px 0;">&copy; {{year}} Autogenious. All rights reserved.</p>
<p style="margin: 0;"><a style="color: #4f46e5; text-decoration: underline;" href="{{website_link}}" target="_blank" rel="noopener noreferrer">Visit our website</a></p>
</td>
</tr>
</tbody>
</table>',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Forgot Password',
                'subject' => 'Reset Your Autogenious Password',
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
<p style="margin: 0 0 5px 0;">&mdash; The Autogenious Team</p>
</td>
</tr>

</tbody>
</table>',
                'is_published' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
};