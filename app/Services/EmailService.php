<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\GenericMail;
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
            $subject = $this->replacePlaceholders($template->subject, $data)
                ?? $fallbackSubject
                ?? 'No Subject';

            // QUEUE PROPERLY
            Mail::to($to)->queue(new GenericMail($body, $subject));

            Log::info("Email queued successfully for {$to} using template '{$templateTitle}'.");
            return true;
        } catch (Exception $e) {
            Log::error("Failed to queue email to {$to} (Template: {$templateTitle}): " . $e->getMessage());
            return false;
        }
    }

    public function sendEmailInstant(
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
            $subject = $this->replacePlaceholders($template->subject, $data);

            Mail::html($body, function ($message) use ($to, $subject, $fallbackSubject) {
                $message->to($to)
                    ->subject($subject ?? $fallbackSubject ?? 'No Subject');
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
            '{name}' => $contact->name ?? '',
            '{email}' => $contact->email ?? '',
            '{message}' => $contact->message ?? '',
            '{mobile_no}' => $contact->mobile_no ?? '',
            '{support_email}' => config('mail.from.address', 'support@example.com'),
            '{company_name}' => config('settings.site_name', 'CC'),
            '{year}' => now()->year,
            '{website_link}' => config('app.url', url('/')),
            '{date}' => now()->format('d-m-Y H:i:s')
        ];

        // Admin
        return $this->sendEmailInstant(
            config('settings.admin_email', 'anubhav.abstain@gmail.com'),
            'Contact Us - Admin',
            $data,
            'New Contact Inquiry'
        );
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
            '{name}' => $request->name ?? '',
            '{email}' => $request->email ?? '',
            '{date}' => now()->format('d-m-Y H:i:s'),
            '{reset_url}' => $request->reset_url ?? '#',
            '{support_email}' => config('mail.from.address', 'support@example.com'),
            '{company_name}' => config('settings.site_name', 'CC'),
            '{year}' => now()->year,
            '{website_link}' => config('app.url', url('/')),
        ];



        // Send to Client (password reset email)
        return $this->sendEmailInstant(
            $request->email,
            'Forgot Password',
            $data,
            'Password Reset Instructions'
        );
    }

    /**
     * Send a Welcome email to a newly registered user.
     *
     * @param User $user
     * @return bool
     */
    public function welcomeEmail(User $user): bool
    {
        $data = [
            '{name}' => $user->name ?? 'there',
            '{email}' => $user->email,
            '{dashboard_url}' => url('/dashboard'), // Or config('app.url') . '/dashboard'
            '{support_email}' => config('settings.contact_email', 'support@autogenious.com'),
            '{company_name}' => config('settings.site_name', 'Autogenious'),
            '{year}' => now()->year,
            '{website_link}' => config('app.url', url('/')),
        ];

        return $this->sendEmailInstant(
            $user->email,
            'Welcome Email',
            $data,
            'Welcome to Autogenious!'
        );
    }

    /**
     * Send consultation confirmation email to the user.
     *
     * @param \App\Models\Consultation $consultation
     * @return bool
     */
    public function consultationUserConfirmation($consultation): bool
    {
        $data = [
            '{name}' => $consultation->name ?? '',
            '{email}' => $consultation->email ?? '',
            '{phone}' => $consultation->phone ?? '',
            '{subject}' => $consultation->subject ?? '',
            '{preferred_date}' => $consultation->preferred_date ?? '',
            '{message}' => $consultation->message ?? '',
            '{status}' => ucfirst($consultation->status),
            '{amount}' => $consultation->amount,
            '{payment_status}' => ucfirst($consultation->payment_status),
            '{year}' => now()->year,
            '{website_link}' => config('app.url'),
        ];

        return $this->sendEmail(
            $consultation->email,
            'Book a Consultation - Confirmation',
            $data,
            'Consultation Request Confirmation'
        );
    }
    /**
     * Send consultation notification email to admin and consultant.
     *
     * @param \App\Models\Consultation $consultation
     * @return void
     */
    public function consultationAdminAndConsultant($consultation): void
    {
        $data = [
            '{name}' => $consultation->name ?? '',
            '{email}' => $consultation->email ?? '',
            '{phone}' => $consultation->phone ?? '',
            '{subject}' => $consultation->subject ?? '',
            '{preferred_date}' => $consultation->preferred_date ?? '',
            '{message}' => $consultation->message ?? '',
            '{status}' => ucfirst($consultation->status),
            '{amount}' => $consultation->amount,
            '{payment_status}' => ucfirst($consultation->payment_status),
            '{year}' => now()->year,
            '{website_link}' => config('app.url'),
        ];

        // Admin
        $this->sendEmail(
            config('settings.admin_email', 'admin@example.com'),
            'Book a Consultation - Admin',
            $data,
            'New Consultation Booked'
        );

        // Consultant
        $this->sendEmail(
            config('settings.consultant_email', 'consultant@example.com'),
            'Book a Consultation - Consultant',
            $data,
            'New Consultation Assigned'
        );
    }

}
