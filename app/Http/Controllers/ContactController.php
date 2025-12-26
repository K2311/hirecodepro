<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Show the contact form
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Store a new contact inquiry
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'inquiry_type' => 'required|in:general,service,support,partnership,product',
            'product_id' => 'nullable|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            ContactInquiry::create([
                'product_id' => $request->product_id,
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'inquiry_type' => $request->inquiry_type,
                'status' => 'new',
                'source_page' => $request->source_page ?? url()->previous(),
                'metadata' => [
                    'user_agent' => $request->userAgent(),
                    'ip_address' => $request->ip(),
                    'referer' => $request->header('referer'),
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your inquiry! We\'ll get back to you within 24 hours.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your inquiry. Please try again or contact us directly.'
            ], 500);
        }
    }

    /**
     * Show success page after form submission
     */
    public function success()
    {
        return view('contact-success');
    }
}