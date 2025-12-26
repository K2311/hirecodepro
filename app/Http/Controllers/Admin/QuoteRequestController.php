<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use App\Models\User;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QuoteRequest::with(['assignee', 'client']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('project_type', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Assigned to filter
        if ($request->has('assigned_to') && !empty($request->assigned_to)) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $quotes = $query->latest()->paginate(15);
        $users = User::where('role', '!=', 'client')->select('id', 'full_name')->get();

        return view('admin.quotes.index', compact('quotes', 'users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(QuoteRequest $quote)
    {
        $quote->load(['assignee', 'client', 'emailConversations']);

        // Mark as 'contacted' if it's new and being viewed for the first time? 
        // Or keep as is for now.

        $users = User::where('role', '!=', 'client')->select('id', 'full_name')->get();

        return view('admin.quotes.show', compact('quote', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuoteRequest $quote)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,quoted,accepted,rejected,archived',
            'assigned_to' => 'nullable|exists:users,id',
            'quoted_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:2000',
        ]);

        $quote->update($validated);

        return redirect()->back()->with('success', 'Quote request updated successfully.');
    }

    /**
     * Assign quote to a user.
     */
    public function assign(Request $request, QuoteRequest $quote)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $quote->update([
            'assigned_to' => $validated['assigned_to'],
        ]);

        return redirect()->back()->with('success', 'Quote request assigned successfully.');
    }

    /**
     * Bulk update quotes.
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'quote_ids' => 'required|array',
            'quote_ids.*' => 'exists:quote_requests,id',
            'action' => 'required|in:mark_contacted,mark_quoted,mark_archived,assign',
            'assigned_to' => 'required_if:action,assign|exists:users,id',
        ]);

        $quotes = QuoteRequest::whereIn('id', $validated['quote_ids'])->get();

        switch ($validated['action']) {
            case 'mark_contacted':
                $quotes->each->update(['status' => 'contacted']);
                $message = 'Selected quotes marked as contacted.';
                break;
            case 'mark_quoted':
                $quotes->each->update(['status' => 'quoted']);
                $message = 'Selected quotes marked as quoted.';
                break;
            case 'mark_archived':
                $quotes->each->update(['status' => 'archived']);
                $message = 'Selected quotes marked as archived.';
                break;
            case 'assign':
                $quotes->each->update([
                    'assigned_to' => $validated['assigned_to']
                ]);
                $message = 'Selected quotes assigned successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuoteRequest $quote)
    {
        $quote->delete();
        return redirect()->route('admin.quotes.index')->with('success', 'Quote request deleted.');
    }
}
