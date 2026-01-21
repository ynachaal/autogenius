<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmailTemplateController extends Controller
{
    protected const PER_PAGE = 10;
    protected const ALLOWED_SORTS = ['id', 'title', 'is_published', 'created_at'];

    public function index(Request $request)
    {
        $search = $request->input('search');
        $is_published = $request->input('is_published');

        $query = EmailTemplate::when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when(in_array($is_published, ['0', '1']), fn($q) => $q->where('is_published', $is_published));

        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = strtolower($request->input('sort_direction', 'asc')) === 'asc' ? 'asc' : 'desc';
        
        if (!in_array($sortBy, self::ALLOWED_SORTS)) {
            $sortBy = 'id';
        }

        $emailTemplates = $query->orderBy($sortBy, $sortDirection)
            ->paginate(self::PER_PAGE)
            ->appends($request->query());

        return view('admin.email-templates.index', compact('emailTemplates', 'sortBy', 'sortDirection', 'is_published'));
    }

    public function create()
    {
        return view('admin.email-templates.create');
    }

    public function store(Request $request)
    {
        $emailTemplate = EmailTemplate::create($this->validateEmailTemplate($request));

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Email template created successfully.');
    }

    public function show(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates.show', compact('emailTemplate'));
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $emailTemplate->update($this->validateEmailTemplate($request));

        return redirect()->route('admin.email-templates.show', $emailTemplate)
            ->with('success', 'Email template updated successfully.');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        try {
            $emailTemplate->delete();
            return redirect()->route('admin.email-templates.index')
                ->with('success', 'Email template deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.email-templates.index')
                ->with('error', "Failed to delete email template: {$e->getMessage()}");
        }
    }

    protected function validateEmailTemplate(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|min:5|max:50',
            'subject' => 'required|string|min:5|max:50',
            'content' => 'required|string|min:10',
            'is_published' => 'boolean',
        ]);
    }
}