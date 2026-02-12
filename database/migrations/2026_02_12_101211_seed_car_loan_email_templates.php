<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration {

    public function up(): void
    {
        $now = Carbon::now();

        // 1. ADMIN TEMPLATE
        DB::table('email_templates')->updateOrInsert(
            ['title' => 'Car Loan - Admin'],
            [
                'subject' => 'New Car Loan Application from AutoGenius',
                'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #0d6efd; color: #ffffff; text-align: center; padding: 20px;">
<h2 style="margin: 0; font-size: 24px; font-weight: bold;">New Car Loan Request</h2>
</td>
</tr>
<tr>
<td style="padding: 20px; color: #333333; background-color: #ffffff; font-size: 16px;">
<p style="margin: 0 0 10px 0;">Hello <strong>Admin</strong>,</p>
<p style="margin: 0 0 15px 0;">A new car loan application has been submitted. Details below:</p>
<table style="width: 100%; border-collapse: collapse; border: 1px solid #eeeeee;">
<tr><td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Loan Type</td><td style="padding: 8px;">{{loan_type}}</td></tr>
<tr><td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Customer Name</td><td style="padding: 8px;">{{customer_name}}</td></tr>
<tr><td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Email</td><td style="padding: 8px;">{{customer_email}}</td></tr>
<tr><td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Mobile</td><td style="padding: 8px;">{{customer_mobile}}</td></tr>
<tr><td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">City</td><td style="padding: 8px;">{{city}}</td></tr>
<tr><td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Date</td><td style="padding: 8px;">{{date}}</td></tr>
</table>
<p style="margin: 15px 0 0 0;">Please contact the applicant within 24 hours.</p>
</td>
</tr>
</tbody>
</table>',
                'is_published' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // 2. USER TEMPLATE
        DB::table('email_templates')->updateOrInsert(
            ['title' => 'Car Loan - User Confirmation'],
            [
                'subject' => 'Loan Application Received - AutoGenius',
                'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #198754; color: #ffffff; text-align: center; padding: 20px;">
<h2 style="margin: 0; font-size: 24px; font-weight: bold;">Application Received!</h2>
</td>
</tr>
<tr>
<td style="padding: 20px; color: #333333; background-color: #ffffff; font-size: 16px;">
<p style="margin: 0 0 10px 0;">Hi <strong>{{customer_name}}</strong>,</p>
<p style="margin: 0 0 15px 0;">Thank you for applying for a <strong>{{loan_type}}</strong> through AutoGenius. We have received your details:</p>
<table style="width: 100%; border-collapse: collapse; border: 1px solid #eeeeee;">
<tr><td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Loan Type</td><td style="padding: 8px;">{{loan_type}}</td></tr>
<tr><td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Location</td><td style="padding: 8px;">{{city}}</td></tr>
</table>
<p style="margin: 15px 0 0 0;">Our loan experts are reviewing your profile and will call you shortly to discuss the next steps.</p>
</td>
</tr>
</tbody>
</table>',
                'is_published' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    public function down(): void
    {
        DB::table('email_templates')
            ->whereIn('title', ['Car Loan - Admin', 'Car Loan - User Confirmation'])
            ->delete();
    }
};