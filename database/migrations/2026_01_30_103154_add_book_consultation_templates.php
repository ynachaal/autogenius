<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration {
    public function up(): void
    {
        $now = Carbon::now();

        $templates = [

            // USER CONFIRMATION
            [
                'title' => 'Book a Consultation - Confirmation',
                'subject' => 'Your Consultation Request Has Been Received',
                'content' => '<table style="max-width:600px;width:100%;margin:0 auto;background:#fff;border-collapse:collapse">
<tbody>
<tr>
<td style="background:#4f46e5;color:#fff;text-align:center;padding:25px">
<h2 style="margin:0;font-size:26px">Consultation Request Confirmation</h2>
</td>
</tr>

<tr>
<td style="padding:25px;font-size:16px;color:#333">
<p>Hi <strong>{{name}}</strong>,</p>

<p>
Thank you for booking a consultation with us. We have successfully received your request and payment.
</p>

<table style="width:100%;border:1px solid #eee;margin:20px 0;border-collapse:collapse">
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Subject</td>
<td style="padding:10px">{{subject}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Preferred Date</td>
<td style="padding:10px">{{preferred_date}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Amount Paid</td>
<td style="padding:10px"><strong>₹{{amount}}</strong></td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Status</td>
<td style="padding:10px">{{status}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Message</td>
<td style="padding:10px">{{message}}</td>
</tr>
</table>

<p>
Our team will contact you shortly to confirm the consultation schedule.
</p>

<p><strong>— autogenius Team</strong></p>
</td>
</tr>

<tr>
<td style="background:#f1f3f5;text-align:center;padding:15px;font-size:13px">
&copy; {{year}} autogenius. All rights reserved.
</td>
</tr>
</tbody>
</table>',
            ],

            // ADMIN NOTIFICATION
            [
                'title' => 'Book a Consultation - Admin',
                'subject' => 'New Consultation Booked (Payment Received)',
                'content' => '<table style="max-width:600px;width:100%;margin:0 auto;background:#fff;border-collapse:collapse">
<tbody>
<tr>
<td style="background:#4f46e5;color:#fff;text-align:center;padding:25px">
<h2 style="margin:0;font-size:26px">New Consultation Booked</h2>
</td>
</tr>

<tr>
<td style="padding:25px;font-size:16px;color:#333">
<p>Hello <strong>Admin</strong>,</p>

<p>
A new consultation has been booked and payment has been successfully received.
</p>

<table style="width:100%;border:1px solid #eee;margin:20px 0;border-collapse:collapse">
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Name</td>
<td style="padding:10px">{{name}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Email</td>
<td style="padding:10px">{{email}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Phone</td>
<td style="padding:10px">{{phone}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Subject</td>
<td style="padding:10px">{{subject}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Preferred Date</td>
<td style="padding:10px">{{preferred_date}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Amount Paid</td>
<td style="padding:10px"><strong>₹{{amount}}</strong></td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Payment Status</td>
<td style="padding:10px">{{payment_status}}</td>
</tr>
<tr>
<td style="padding:10px;font-weight:bold;background:#f9fafb">Message</td>
<td style="padding:10px">{{message}}</td>
</tr>
</table>

<p>Please follow up to schedule the consultation.</p>
</td>
</tr>

<tr>
<td style="background:#f1f3f5;text-align:center;padding:15px;font-size:13px">
&copy; {{year}} autogenius. All rights reserved.
</td>
</tr>
</tbody>
</table>',
            ],
        ];

        foreach ($templates as $template) {
            DB::table('email_templates')->updateOrInsert(
                ['title' => $template['title']],
                [
                    'subject' => $template['subject'],
                    'content' => $template['content'],
                    'is_published' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    public function down(): void
    {
        DB::table('email_templates')
            ->whereIn('title', [
                'Book a Consultation - Confirmation',
                'Book a Consultation - Admin',
            ])
            ->delete();
    }
};
