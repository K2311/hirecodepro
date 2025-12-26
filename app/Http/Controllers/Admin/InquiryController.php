<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ContactInquiry::with('assignee');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('inquiry_type', $request->type);
        }

        // Assigned to filter
        if ($request->has('assigned_to') && !empty($request->assigned_to)) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $inquiries = $query->latest()->paginate(15);

        $users = User::where('role', '!=', 'client')->select('id', 'full_name')->get();

        return view('admin.inquiries.index', compact('inquiries', 'users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactInquiry $inquiry)
    {
        $inquiry->load('assignee', 'emailConversations');

        // Mark as read if it's new
        if ($inquiry->status === 'new') {
            $inquiry->update(['status' => 'read']);
        }

        $users = User::where('role', '!=', 'client')->select('id', 'full_name')->get();

        return view('admin.inquiries.show', compact('inquiry', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactInquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,read,replied,closed',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $inquiry->update($validated);

        return redirect()->back()->with('success', 'Inquiry updated successfully.');
    }

    /**
     * Assign inquiry to a user.
     */
    public function assign(Request $request, ContactInquiry $inquiry)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $inquiry->update([
            'assigned_to' => $validated['assigned_to'],
            'status' => 'read' // Mark as read when assigned
        ]);

        return redirect()->back()->with('success', 'Inquiry assigned successfully.');
    }

    /**
     * Send reply to inquiry.
     */
    public function reply(Request $request, ContactInquiry $inquiry)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|min:10',
        ]);

        // Here you would typically send an email
        // For now, we'll just update the status and add to email conversations

        $inquiry->emailConversations()->create([
            'from_email' => auth()->user()->email,
            'to_email' => $inquiry->email,
            'subject' => 'Re: ' . $inquiry->subject,
            'body_text' => $validated['reply_message'],
            'direction' => 'outgoing',
            'status' => 'sent',
        ]);

        $inquiry->update(['status' => 'replied']);

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }

    /**
     * Bulk update inquiries.
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'inquiry_ids' => 'required|array',
            'inquiry_ids.*' => 'exists:contact_inquiries,id',
            'action' => 'required|in:mark_read,mark_replied,mark_closed,assign',
            'assigned_to' => 'required_if:action,assign|exists:users,id',
        ]);

        $inquiries = ContactInquiry::whereIn('id', $validated['inquiry_ids'])->get();

        switch ($validated['action']) {
            case 'mark_read':
                $inquiries->each->update(['status' => 'read']);
                $message = 'Selected inquiries marked as read.';
                break;
            case 'mark_replied':
                $inquiries->each->update(['status' => 'replied']);
                $message = 'Selected inquiries marked as replied.';
                break;
            case 'mark_closed':
                $inquiries->each->update(['status' => 'closed']);
                $message = 'Selected inquiries marked as closed.';
                break;
            case 'assign':
                $inquiries->each->update([
                    'assigned_to' => $validated['assigned_to'],
                    'status' => 'read'
                ]);
                $message = 'Selected inquiries assigned successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}