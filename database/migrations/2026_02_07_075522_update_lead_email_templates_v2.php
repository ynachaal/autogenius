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
        // Update User Confirmation Template
        DB::table('email_templates')
            ->where('title', 'Lead Inquiry Confirmation - User')
            ->update([
                'content' => $this->getUserTemplateHtml(),
                'updated_at' => Carbon::now(),
            ]);

        // Update Admin Notification Template
        DB::table('email_templates')
            ->where('title', 'New Lead Alert - Admin')
            ->update([
                'content' => $this->getAdminTemplateHtml(),
                'updated_at' => Carbon::now(),
            ]);
    }

    /**
     * Reverse the migrations.
     * Note: This usually involves restoring the previous hardcoded versions if needed.
     */
    public function down(): void
    {
        // No-op or restore to previous versions
    }

    private function getUserTemplateHtml(): string
    {
        return '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 30px;">
<h2 style="margin: 0; font-size: 28px; font-weight: bold;">Inquiry Received!</h2>
</td>
</tr>
<tr>
<td style="padding: 30px; color: #333333; background-color: #ffffff; font-size: 16px; line-height: 1.6;">
<p style="margin: 0 0 15px 0;">Hi <strong>{{full_name}}</strong>,</p>
<p style="margin: 0 0 15px 0;">Thank you for reaching out to Autogenious! We have successfully received your inquiry for <strong>{{service_required}}</strong>.</p>
<p style="margin: 0 0 15px 0;">Our team is currently reviewing your preferences for <strong>{{fuel_preference}}</strong> vehicles in the <strong>{{body_type}}</strong> category. We will contact you shortly via <strong>{{preferred_contact_method}}</strong>.</p>
<p style="margin: 30px 0 5px 0; font-weight: bold;">Best Regards,</p>
<p style="margin: 0;">The Autogenious Team</p>
</td>
</tr>
<tr>
<td style="background-color: #f9fafb; color: #9ca3af; text-align: center; padding: 20px; font-size: 12px;">
<p style="margin: 0 0 5px 0;">&copy; {{year}} Autogenious. All rights reserved.</p>
</td>
</tr>
</tbody>
</table>';
    }

    private function getAdminTemplateHtml(): string
    {
        return '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse;" role="presentation" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="background-color: #4f46e5; color: #ffffff; text-align: center; padding: 30px;">
<h2 style="margin: 0; font-size: 28px; font-weight: bold;">New Lead Captured</h2>
</td>
</tr>
<tr>
<td style="padding: 30px; color: #333333; background-color: #ffffff; font-size: 16px; line-height: 1.6;">
<p style="margin: 0 0 15px 0;">Hello Admin,</p>
<p style="margin: 0 0 15px 0;">A new lead has been submitted with the following details:</p>
<div style="background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
<p style="margin: 0 0 10px 0;"><strong>Name:</strong> {{full_name}}</p>
<p style="margin: 0 0 10px 0;"><strong>Contact:</strong> {{mobile}} ({{preferred_contact_method}})</p>
<p style="margin: 0 0 10px 0;"><strong>Service:</strong> {{service_required}}</p>
<p style="margin: 0 0 10px 0;"><strong>Payment Status:</strong> {{payment_status}}</p>
<p style="margin: 0 0 10px 0;"><strong>Base Budget:</strong> ₹{{budget}}</p>
<p style="margin: 0 0 10px 0;"><strong>Max Stretch:</strong> ₹{{max_budget}}</p>
<p style="margin: 0 0 10px 0;"><strong>Location:</strong> {{city}}</p>
<p style="margin: 0;"><strong>Usage:</strong> {{approx_running}} km/month</p>
</div>
<p style="margin: 0 0 25px 0;">Please log in to the admin panel to view the full requirements including usage patterns and vehicle preferences.</p>
<p style="margin: 25px 0; text-align: center;">
<a style="display: inline-block; padding: 12px 28px; background-color: #111827; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 5px; font-size: 18px;" href="{{admin_url}}" target="_blank" rel="noopener noreferrer">View Full Lead</a>
</p>
<p style="margin: 30px 0 5px 0; font-weight: bold;">System Notification,</p>
<p style="margin: 0;">Autogenious CRM</p>
</td>
</tr>
<tr>
<td style="background-color: #f9fafb; color: #9ca3af; text-align: center; padding: 20px; font-size: 12px;">
<p style="margin: 0 0 5px 0;">&copy; {{year}} Autogenious. Internal Use Only.</p>
</td>
</tr>
</tbody>
</table>';
    }
};