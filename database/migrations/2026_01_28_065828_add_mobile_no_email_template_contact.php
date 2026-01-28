<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the "Contact Us - Admin" template to include mobile_no
        DB::table('email_templates')
            ->where('title', 'Contact Us - Admin')
            ->update([
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
<p style="margin: 0 0 5px 0;">Sent automatically by Autogenious Website</p>
<p style="margin: 0 0 5px 0;">&copy; {{year}} Autogenious. All rights reserved.</p>
<p style="margin: 0;"><a style="color: #4f46e5; text-decoration: underline;" href="{{website_link}}" target="_blank" rel="noopener noreferrer">Visit our website</a></p>
</td>
</tr>
</tbody>
</table>',
                'updated_at' => Carbon::now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally, you can remove mobile_no placeholder if rolling back
        DB::table('email_templates')
            ->where('title', 'Contact Us - Admin')
            ->update([
                'content' => str_replace(
                    '<tr>
<td style="padding: 10px; font-weight: bold; width: 30%; background-color: #f9fafb; border-bottom: 1px solid #eeeeee;">Mobile No:</td>
<td style="padding: 10px; width: 70%; border-bottom: 1px solid #eeeeee;">{{mobile_no}}</td>
</tr>',
                    '',
                    DB::table('email_templates')->where('title', 'Contact Us - Admin')->value('content')
                ),
                'updated_at' => Carbon::now(),
            ]);
    }
};
