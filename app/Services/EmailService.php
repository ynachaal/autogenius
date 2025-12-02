<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class EmailService
{
    private const PLACEHOLDER_WRAPPER = ['{', '}'];

    /**
     * Send a dynamic email using a DB template.
     *
     * @param string $to
     * @param string $templateTitle
     * @param array $data
     * @param string|null $fallbackSubject
     * @return bool
     */
    public function sendEmail(
        string $to,
        string $templateTitle,
        array $data = [],
        ?string $fallbackSubject = null
    ): bool {
        try {
            $template = EmailTemplate::firstWhere('title', $templateTitle);

            if (!$template) {
                Log::warning("Email template '{$templateTitle}' not found. To: {$to}");
                return false;
            }

            $body = $this->replacePlaceholders($template->content, $data);

            Mail::html($body, function ($message) use ($to, $template, $fallbackSubject) {
                $message->to($to)
                    ->subject($template->subject ?? $fallbackSubject ?? 'No Subject');
            });

            Log::info("Email sent successfully to {$to} using template '{$templateTitle}'.");
            return true;
        } catch (Exception $e) {
            Log::error("Failed to send email to {$to} (Template: {$templateTitle}): " . $e->getMessage());
            return false;
        }
    }

    /**
     * Replace placeholders in the template with actual values.
     *
     * OPTIMIZATION: Uses str_replace for better performance/readability over strtr/array_reduce.
     * Assumes placeholders in the template are the same as keys in the $data array (e.g., {key}).
     *
     * @param string $content
     * @param array $data
     * @return string
     */
    private function replacePlaceholders(string $content, array $data): string
    {
        $search = array_map(
            fn($key) => self::PLACEHOLDER_WRAPPER[0] . $key . self::PLACEHOLDER_WRAPPER[1],
            array_keys($data)
        );
        $replace = array_values($data);

        return str_replace($search, $replace, $content);
    }


    /**
     * Send a "Contact Us" email using the dynamic template system.
     *
     * @param object $contact
     * @return bool
     */
    public function contactUs($contact): bool
    {
        $data = [
            '{name}'          => $contact->name ?? '',
            '{email}'         => $contact->email ?? '',
            '{message}'       => $contact->message ?? '',
            '{support_email}' => config('mail.from.address', 'support@example.com'),
            '{company_name}'  => config('settings.site_name', 'CC'),
            '{year}'          => now()->year,
            '{website_link}'  => config('app.url', url('/')),
            '{date}'          => now()->format('d-m-Y H:i:s')
        ];

        // Admin
        $this->sendEmail(
            config('settings.admin_email', 'sumit.abstain@gmail.com'),
            'Contact Us - Admin',
            $data,
            'New Contact Inquiry'
        );

        // Client
        return $this->sendEmail(
            $contact->email,
            'Contact Us',
            $data,
            'Thank You for Contacting Us'
        );
    }

    /**
     * Send a Client Registration email notification.
     *
     * @param object $request
     * @return bool
     */
    public function ClientRegirsation($request): bool
    {
        $data = [
            '{name}'          => $request->name ?? '',
            '{email}'         => $request->email ?? '',
            '{date}'          => now()->format('d-m-Y H:i:s'),
            '{support_email}' => config('mail.from.address', 'support@example.com'),
            '{company_name}'  => config('settings.site_name', 'CC'),
            '{year}'          => now()->year,
            '{website_link}'  => config('app.url', url('/')),
        ];

        // Admin
        $this->sendEmail(
            config('settings.admin_email', 'sumit.abstain@gmail.com'),
            'Client Registration - Admin',
            $data,
            'New Client Registered.'
        );

        // Client
        return $this->sendEmail(
            $request->email,
            'Client Registration',
            $data,
            'Your Registration has been Successfully done.'
        );
    }

    /**
     * Send an Admin notification for a new Property Inquiry.
     *
     * @param array $param
     * @return bool
     */
    public function PropertyInquiry(array $param): bool
    {
        // OPTIMIZATION: Use Auth::user() directly and check if user is authenticated
        $name = Auth::check() ? Auth::user()->name : 'Anonymous Client';

        $data = [
            '{property_title}'        => $param['title'] ?? 'N/A',
            '{property_area}'         => $param['location'] ?? 'N/A',
            '{property_price}'        => $param['price'] ?? 'N/A',
            '{user_name}'             => $name,
            '{company_name}'          => config('settings.site_name', 'CC'),
            '{admin_dashboard_link}'  => config('app.url', url('/')) . '/admin/inquiries',
            '{year}'          => now()->year,
        ];

        // Admin
        return $this->sendEmail(
            config('settings.admin_email', 'sumit.abstain@gmail.com'),
            'Property Inquiry',
            $data,
            'New Property Inquiry!'
        );
    }
    /**
     * Send an Admin notification for a new Property Inquiry.
     *
     * @param array $param
     * @return bool
     */
    public function PropertyApproved(array $param): bool
    {
        $name = User::where('id', $param['user_id'])->pluck('name')->first() ?? 'Anonymous Client';

        $data = [
            '{property_title}'        => $param['title'] ?? 'N/A',
            '{property_area}'         => $param['location'] ?? 'N/A',
            '{property_price}'        => $param['price'] ?? 'N/A',
            '{user_name}'             => $name,
            '{company_name}'          => config('settings.site_name', 'CC'),
            '{admin_dashboard_link}'  => config('app.url', url('/')),
            '{year}'          => now()->year,
        ];

        // Admin
        return $this->sendEmail(
            config('settings.admin_email', 'sumit.abstain@gmail.com'),
            'Property Approved - Admin',
            $data,
            'New Property Inquiry!'
        );
    }

    /**
     * Send an Client notification for Approval of Developer Partner.
     *
     * @param array $param
     * @return bool
     */
    public function DeveloperPartnerApproved(array $param): bool
    {
        // Get user details properly
        $user = User::where('id', $param['user_id'])->first(['name', 'email']);

        if ($user) {
            $data = [
                '{client_name}'     => $user->name,
                '{partner_name}'    => $param['name'] ?? 'N/A',
                '{company_name}'    => config('settings.site_name', 'CC'),
                '{published_date}'  => now()->format('d-m-Y'),
                '{partner_link}'    => $param['partner_link'] ?? config('app.url', url('/')),
                '{website_link}'    => config('app.url', url('/')),
                '{year}'            => now()->year,
            ];

            return $this->sendEmail(
                $user->email,
                'Developer Partner Approved - Client',
                $data,
                'Developer Partner Approved!'
            );
        }

        return false;
    }
    /**
     * Send an Admin notification for a new Developer Partner submission.
     *
     * @param array $param
     * @return bool
     */
    public function NewDeveloperPartner(array $param): bool
    {
        // Get client (the one who submitted the developer partner)
        $user = User::where('id', $param['user_id'])->first(['name']);

        if ($user) {
            $data = [
                '{partner_name}'    => $param['name'] ?? 'N/A',
                '{submitted_by}'    => $user->name ?? 'Unknown User',
                '{company_name}'    => config('settings.site_name', 'CC'),
                '{submitted_date}'  => now()->format('F d, Y'),
                '{admin_link}'      => $param['admin_link'] ?? config('app.url', url('/admin')),
                '{website_link}'    => config('app.url', url('/')),
                '{year}'            => now()->year,
            ];

            return $this->sendEmail(
                config('settings.admin_email', 'sumit.abstain@gmail.com'),
                'New Developer Partner - Admin',
                $data,
                'New Developer Partner Submission'
            );
        }

        return false;
    }



    /**
     * Send a Forget Password email to the client.
     *
     * @param object $request
     * @return bool
     */
    public function ForgetPassword($request): bool
    {
        // Prepare dynamic placeholders for the email template
        $data = [
            '{name}'          => $request->name ?? '',
            '{email}'         => $request->email ?? '',
            '{date}'          => now()->format('d-m-Y H:i:s'),
            '{reset_url}'     => $request->reset_url ?? '#',
            '{support_email}' => config('mail.from.address', 'support@example.com'),
            '{company_name}'  => config('settings.site_name', 'CC'),
            '{year}'          => now()->year,
            '{website_link}'  => config('app.url', url('/')),
        ];

        // Send to Client (password reset email)
        return $this->sendEmail(
            $request->email,
            'Forget Password',
            $data,
            'Password Reset Instructions'
        );
    }
}
