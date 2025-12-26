<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PortfolioProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PortfolioProject::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('project_type', 'like', "%{$search}%");
            });
        }

        // Filter by state
        if ($request->has('status') && !empty($request->status)) {
            $status = $request->status === 'published';
            $query->where('is_published', $status);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured === '1') {
            $query->where('is_featured', true);
        }

        $projects = $query->orderBy('sort_order')->latest()->paginate(15);

        return view('admin.portfolio.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portfolio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:portfolio_projects,slug',
            'client_name' => 'nullable|string|max:255',
            'project_type' => 'required|string|max:255',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'result' => 'nullable|string',
            'tech_stack' => 'nullable|array',
            'project_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'cover_image_url' => 'nullable|string',
            'images' => 'nullable|array',
            'video_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['published_at'] = $request->is_published ? now() : null;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');

        PortfolioProject::create($validated);

        return redirect()->route('admin.portfolio.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PortfolioProject $portfolio)
    {
        return view('admin.portfolio.show', ['project' => $portfolio]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PortfolioProject $portfolio)
    {
        return view('admin.portfolio.edit', ['project' => $portfolio]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PortfolioProject $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:portfolio_projects,slug,' . $portfolio->id,
            'client_name' => 'nullable|string|max:255',
            'project_type' => 'required|string|max:255',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'result' => 'nullable|string',
            'tech_stack' => 'nullable|array',
            'project_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'cover_image_url' => 'nullable|string',
            'images' => 'nullable|array',
            'video_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        if ($request->has('is_published') && !$portfolio->is_published) {
            $validated['published_at'] = now();
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_published'] = $request->has('is_published');

        $portfolio->update($validated);

        return redirect()->route('admin.portfolio.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PortfolioProject $portfolio)
    {
        $portfolio->delete();
        return redirect()->route('admin.portfolio.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * Handle media file upload
     */
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,webm,ogg|max:51200',
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Root is public/uploads as per config/filesystems.php
                $path = Storage::disk('public')->putFileAs('portfolio', $file, $filename);

                // Consistent with ProductController logic
                $url = asset('uploads/' . $path);

                return response()->json([
                    'success' => true,
                    'url' => $url,
                    'message' => 'File uploaded successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file provided'
            ], 400);
        } catch (\Exception $e) {
            \Log::error('Portfolio Media Upload Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
