<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailConversation;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of email history.
     */
    public function index(Request $request)
    {
        $query = EmailConversation::with(['client', 'inquiry', 'order']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhere('to_email', 'like', "%{$search}%")
                    ->orWhere('from_email', 'like', "%{$search}%")
                    ->orWhere('body_text', 'like', "%{$search}%");
            });
        }

        // Filter by direction
        if ($request->has('direction') && in_array($request->direction, ['incoming', 'outgoing'])) {
            $query->where('direction', $request->direction);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $emails = $query->latest()->paginate(20);

        return view('admin.emails.index', compact('emails'));
    }

    /**
     * Display the specified email.
     */
    public function show($id)
    {
        $email = EmailConversation::with(['client', 'inquiry', 'order'])->findOrFail($id);

        return view('admin.emails.show', compact('email'));
    }

    /**
     * Remove the specified email from logs.
     */
    public function destroy($id)
    {
        $email = EmailConversation::findOrFail($id);
        $email->delete();

        return redirect()->route('admin.emails.index')->with('success', 'Email record deleted successfully.');
    }

    /**
     * Display a listing of email templates.
     */
    public function templates()
    {
        $templates = EmailTemplate::latest()->get();
        return view('admin.emails.templates.index', compact('templates'));
    }

    /**
     * Show form to create a template.
     */
    public function createTemplate()
    {
        return view('admin.emails.templates.create');
    }

    /**
     * Store a new template.
     */
    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_key' => 'required|string|max:255|unique:email_templates',
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'body_text' => 'nullable|string',
            'category' => 'required|string',
            'variables' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        EmailTemplate::create($validated);

        return redirect()->route('admin.emails.templates')->with('success', 'Email template created successfully.');
    }

    /**
     * Show form to edit a template.
     */
    public function editTemplate($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.emails.templates.edit', compact('template'));
    }

    /**
     * Update a template.
     */
    public function updateTemplate(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'template_key' => 'required|string|max:255|unique:email_templates,template_key,' . $template->id,
            'subject' => 'required|string|max:255',
            'body_html' => 'required|string',
            'body_text' => 'nullable|string',
            'category' => 'required|string',
            'variables' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $template->update($validated);

        return redirect()->route('admin.emails.templates')->with('success', 'Email template updated successfully.');
    }

    /**
     * Delete a template.
     */
    public function deleteTemplate($id)
    {
        $template = EmailTemplate::findOrFail($id);
        $template->delete();

        return redirect()->route('admin.emails.templates')->with('success', 'Email template deleted successfully.');
    }
}
