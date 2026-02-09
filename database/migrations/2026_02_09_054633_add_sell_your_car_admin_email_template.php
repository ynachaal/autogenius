<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration {

    public function up(): void
    {
        $now = Carbon::now();

        DB::table('email_templates')->updateOrInsert(
            ['title' => 'Sell Your Car - Admin'], // unique key
            [
                'subject' => 'New Sell Your Car Inquiry from autogenius',
                'content' => '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 20px;">
<h2 style="margin: 0; font-size: 24px; font-weight: bold;">New Sell Your Car Inquiry</h2>
</td>
</tr>

<tr>
<td style="padding: 20px; color: #333333; background-color: #ffffff; font-size: 16px;">
<p style="margin: 0 0 10px 0;">Hello <strong>Admin</strong>,</p>
<p style="margin: 0 0 15px 0;">You’ve received a new <strong>Sell Your Car</strong> request. Details below:</p>

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
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Vehicle</td>
<td style="padding: 8px;">{{vehicle_name}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Year</td>
<td style="padding: 8px;">{{year}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">KMs Driven</td>
<td style="padding: 8px;">{{kms_driven}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">No. of Owners</td>
<td style="padding: 8px;">{{no_of_owners}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Registration No</td>
<td style="padding: 8px;">{{registration_number}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Location</td>
<td style="padding: 8px;">{{car_location}}</td>
</tr>
<tr>
<td style="padding: 8px; font-weight: bold; background-color: #f9fafb;">Submitted At</td>
<td style="padding: 8px;">{{date}}</td>
</tr>
</table>

<p style="margin: 15px 0 0 0;">Please follow up with the customer as soon as possible.</p>
</td>
</tr>

<tr>
<td style="background-color: #f1f3f5; color: #666666; text-align: center; padding: 15px; font-size: 14px;">
<p style="margin: 0;">Sent automatically by autogenius</p>
<p style="margin: 0;">© {{year}} autogenius</p>
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
            ->where('title', 'Sell Your Car - Admin')
            ->delete();
    }
};
