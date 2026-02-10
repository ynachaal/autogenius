<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = '2026-02-10 12:21:00';

        $templates = [
            [
                'title' => 'New Lead - User Confirmation',
                'subject' => 'Inquiry Received: {{service_required}}',
                'content' => $this->wrapInLayout('Thank You!', 'Hi <strong>{{full_name}}</strong>,<br>We have received your inquiry. Here is a summary of the details you shared:', '#4f46e5', [
                    'Service' => '{{service_required}}',
                    'Budget' => '₹{{budget}}',
                    'Location' => '{{city}}',
                    'Contact' => '{{mobile}}'
                ]),
            ],
            [
                'title' => 'Sell Your Car - User Confirmation',
                'subject' => 'We’ve Received Your Listing - {{vehicle_name}}',
                'content' => $this->wrapInLayout('Car Listing Received', 'Hi <strong>{{customer_name}}</strong>,<br>Your request to sell your car has been registered. Our team will review the details below:', '#4f46e5', [
                    'Vehicle' => '{{vehicle_name}}',
                    'Reg No' => '{{registration_number}}',
                    'KMs Driven' => '{{kms_driven}}',
                    'Location' => '{{car_location}}'
                ]),
            ],
            [
                'title' => 'Car Inspection - User Confirmation',
                'subject' => 'Inspection Scheduled: {{vehicle_name}}',
                'content' => $this->wrapInLayout('Inspection Confirmed', 'Hi <strong>{{customer_name}}</strong>,<br>Your car inspection is confirmed. Please ensure the vehicle is available at the time below:', '#0ea5e9', [
                    'Vehicle' => '{{vehicle_name}}',
                    'Date' => '{{inspection_date}}',
                    'Location' => '{{inspection_location}}',
                    'Payment' => '{{payment_status}}'
                ]),
            ],
            [
                'title' => 'Service Insurance Claim - User Confirmation',
                'subject' => 'Insurance Claim Acknowledgment',
                'content' => $this->wrapInLayout('Claim Received', 'Hi <strong>{{customer_name}}</strong>,<br>We have received your insurance claim request for <strong>{{service_type}}</strong>. Summary:', '#4f46e5', [
                    'Service Type' => '{{service_type}}',
                    'Status' => 'Under Review',
                    'Submitted At' => '{{date}}'
                ]),
            ],
            [
                'title' => 'Call Consultation - User Confirmation',
                'subject' => 'Consultation Booked: {{selected_service}}',
                'content' => $this->wrapInLayout('Consultation Confirmed', 'Hi <strong>{{customer_name}}</strong>,<br>Your expert consultation is booked. Our team will call you shortly.', '#0d6efd', [
                    'Service' => '{{selected_service}}',
                    'Mobile' => '{{customer_mobile}}',
                    'Verified' => 'Yes'
                ]),
            ]
        ];

        foreach ($templates as $template) {
            DB::table('email_templates')->insert(array_merge($template, [
                'is_published' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]));
        }
    }

    private function wrapInLayout($header, $intro, $color, $fields)
    {
        $rows = '';
        foreach ($fields as $label => $value) {
            $rows .= '<tr>
                        <td style="padding: 8px; font-weight: bold; background-color: #f9fafb; border: 1px solid #eeeeee; width: 35%;">'.$label.'</td>
                        <td style="padding: 8px; border: 1px solid #eeeeee;">'.$value.'</td>
                      </tr>';
        }

        return '<table style="max-width: 600px; width: 100%; margin: 0 auto; background-color: #ffffff; border-collapse: collapse; font-family: sans-serif;" role="presentation" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr><td style="background-color: '.$color.'; color: #ffffff; text-align: center; padding: 20px;"><h2 style="margin: 0; font-size: 24px;">'.$header.'</h2></td></tr>
                    <tr><td style="padding: 20px; color: #333333; font-size: 16px; line-height: 1.6;">
                        <p>'.$intro.'</p>
                        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">'.$rows.'</table>
                        <p>If any details are incorrect, please contact us immediately.</p>
                        <p>Best Regards,<br><strong>The autogenius Team</strong></p>
                    </td></tr>
                    <tr><td style="background-color: #f1f3f5; color: #666666; text-align: center; padding: 15px; font-size: 14px;">
                        <p style="margin: 0;">Sent automatically by autogenius</p>
                        <p style="margin: 0;">© 2026 autogenius</p>
                    </td></tr>
                </tbody></table>';
    }

    public function down(): void
    {
        DB::table('email_templates')->where('title', 'LIKE', '%- User Confirmation')->delete();
    }
};