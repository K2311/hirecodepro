<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BlogPost::published()->with(['category', 'author'])->latest();

        // Filter by category if provided
        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(9)->withQueryString();
        $categories = BlogCategory::active()->withCount('posts')->get();
        $recentPosts = BlogPost::published()->latest()->take(5)->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $post)
    {
        // Ensure the post is published
        if ($post->status !== 'published' || !$post->published_at) {
            abort(404);
        }

        // Increment view count
        $post->increment('view_count');

        $categories = BlogCategory::active()->withCount('posts')->get();
        $recentPosts = BlogPost::published()->where('id', '!=', $post->id)->latest()->take(5)->get();

        // Related posts by category
        $relatedPosts = BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'categories', 'recentPosts', 'relatedPosts'));
    }
}
