<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration {

    public function up(): void
    {
        $now = Carbon::now();

        DB::table('email_templates')->updateOrInsert(
            ['title' => 'Call Consultation - Admin'], // unique key
            [
                'subject' => 'New Consultation Request Received - autogenius',
                'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #0d6efd; color: #ffffff; text-align: center; padding: 20px;">
<h2 style="margin: 0; font-size: 24px; font-weight: bold;">New Consultation Request</h2>
</td>
</tr>

<tr>
<td style="padding: 20px; color: #333333; background-color: #ffffff; font-size: 16px;">
<p style="margin: 0 0 10px 0;">Hello <strong>Admin</strong>,</p>
<p style="margin: 0 0 15px 0;">A new <strong>Call Consultation</strong> has been booked and payment has been verified. Details are provided below:</p>

<table style="width: 100%; border-collapse: collapse; border: 1px solid #eeeeee;">
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb; border: 1px solid #eeeeee;">Customer Name</td>
<td style="padding: 8px; border: 1px solid #eeeeee;">{{customer_name}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb; border: 1px solid #eeeeee;">Mobile</td>
<td style="padding: 8px; border: 1px solid #eeeeee;">{{customer_mobile}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb; border: 1px solid #eeeeee;">Email</td>
<td style="padding: 8px; border: 1px solid #eeeeee;">{{customer_email}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb; border: 1px solid #eeeeee;">Service Selected</td>
<td style="padding: 8px; border: 1px solid #eeeeee;">{{selected_service}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb; border: 1px solid #eeeeee;">Page Source</td>
<td style="padding: 8px; border: 1px solid #eeeeee;">{{service_type}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb; border: 1px solid #eeeeee;">Status</td>
<td style="padding: 8px; border: 1px solid #eeeeee;">{{status}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb; border: 1px solid #eeeeee;">Date</td>
<td style="padding: 8px; border: 1px solid #eeeeee;">{{date}}</td>
</tr>
</table>

<p style="margin: 15px 0 0 0;">Please contact the customer to schedule the expert call as soon as possible.</p>
</td>
</tr>

<tr>
<td style="background-color: #f1f3f5; color: #666666; text-align: center; padding: 15px; font-size: 14px;">
<p style="margin: 0;">Sent automatically by autogenius</p>
<p style="margin: 0;">© ' . $now->year . ' autogenius</p>
</td>
</tr>
</tbody>
</table>',
                'is_published' => 1,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }

    public function down(): void
    {
        DB::table('email_templates')
            ->where('title', 'Call Consultation - Admin')
            ->delete();
    }
};