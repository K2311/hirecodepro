<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    /**
     * Show the quote request form
     */
    public function index()
    {
        return view('quote.create');
    }

    /**
     * Store a new quote request
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'project_type' => 'required|string|max:255',
            'description' => 'required|string|max:3000',
            'budget_range' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255',
            'services_needed' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            QuoteRequest::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Your quote request has been submitted successfully! Our team will contact you soon.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error processing your request. Please try again.'
            ], 500);
        }
    }
}
