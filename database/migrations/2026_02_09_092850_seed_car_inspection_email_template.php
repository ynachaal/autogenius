<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration {

    public function up(): void
    {
        $now = Carbon::now();

        DB::table('email_templates')->updateOrInsert(
            ['title' => 'Car Inspection - Admin'], // unique key
            [
                'subject' => 'New Car Inspection Request from autogenius',
                'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #0ea5e9; color: #ffffff; text-align: center; padding: 20px;">
<h2 style="margin: 0; font-size: 24px; font-weight: bold;">New Car Inspection Request</h2>
</td>
</tr>

<tr>
<td style="padding: 20px; color: #333333; background-color: #ffffff; font-size: 16px;">
<p style="margin: 0 0 10px 0;">Hello <strong>Admin</strong>,</p>
<p style="margin: 0 0 15px 0;">A new <strong>Car Inspection</strong> has been scheduled. Details below:</p>

<table style="width: 100%; border-collapse: collapse; border: 1px solid #eeeeee;">
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Customer Name</td>
<td style="padding: 8px;">{{customer_name}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Mobile</td>
<td style="padding: 8px;">{{customer_mobile}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Email</td>
<td style="padding: 8px;">{{customer_email}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Vehicle</td>
<td style="padding: 8px;">{{vehicle_name}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Inspection Date</td>
<td style="padding: 8px;">{{inspection_date}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Location</td>
<td style="padding: 8px;">{{inspection_location}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Payment Status</td>
<td style="padding: 8px;">{{payment_status}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Submitted At</td>
<td style="padding: 8px;">{{date}}</td>
</tr>
</table>

<p style="margin: 15px 0 0 0;">Please ensure an inspector is assigned for the requested date.</p>
</td>
</tr>

<tr>
<td style="background-color: #f1f3f5; color: #666666; text-align: center; padding: 15px; font-size: 14px;">
<p style="margin: 0;">Sent automatically by autogenius</p>
<p style="margin: 0;">© 2026 autogenius</p>
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
            ->where('title', 'Car Inspection - Admin')
            ->delete();
    }
};