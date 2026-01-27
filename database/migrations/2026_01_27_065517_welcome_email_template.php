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
        DB::table('email_templates')->insert([
            'title' => 'Welcome Email',
            'subject' => 'Welcome to Autogenious!',
            'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 30px;">
<h2 style="margin: 0; font-size: 28px; font-weight: bold;">Welcome to Autogenious!</h2>
</td>
</tr>
<tr>
<td style="padding: 30px; color: #333333; background-color: #ffffff; font-size: 16px; line-height: 1.6;">
<p style="margin: 0 0 15px 0;">Hi <strong>{{name}}</strong>,</p>
<p style="margin: 0 0 15px 0;">We’re thrilled to have you join us! At Autogenious, we are dedicated to providing you with the best tools to streamline your workflow and boost your productivity.</p>
<p style="margin: 0 0 25px 0;">To get started, we recommend exploring your dashboard and setting up your profile details.</p>
<p style="margin: 25px 0; text-align: center;">
<a style="display: inline-block; padding: 12px 28px; background-color: #4f46e5; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; font-size: 18px;" href="{{dashboard_url}}" target="_blank" rel="noopener noreferrer">Get Started Now</a>
</p>
<p style="margin: 0 0 15px 0;">If you have any questions or need a helping hand, simply reply to this email. Our support team is always here for you.</p>
<p style="margin: 30px 0 5px 0; font-weight: bold;">Best Regards,</p>
<p style="margin: 0;">The Autogenious Team</p>
</td>
</tr>
<tr>
<td style="background-color: #f9fafb; color: #9ca3af; text-align: center; padding: 20px; font-size: 12px;">
<p style="margin: 0 0 5px 0;">&copy; {{year}} Autogenious. All rights reserved.</p>
<p style="margin: 0;">You received this email because you signed up for an account on our website.</p>
</td>
</tr>
</tbody>
</table>',
            'is_published' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('email_templates')->where('title', 'Welcome Email')->delete();
    }
};