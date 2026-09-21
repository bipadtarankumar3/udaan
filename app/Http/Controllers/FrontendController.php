<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Homepage.
     */
    public function index()
    {
        return view('frontend.index');
    }

    /**
     * Apply Now / Student Registration Form.
     */
    public function apply()
    {
        return view('frontend.apply');
    }

    /**
     * Dynamic Student Application Submission (Only 8 Required Fields).
     */
    public function storeApply(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'phone' => 'required|string|min:10|max:15',
            'whatsapp_no' => 'required|string|min:10|max:15',
            'qualification' => 'required|string|max:100',
            'gender' => 'required|string|in:Male,Female,Other,male,female,other',
            'address' => 'required|string|max:500',
        ]);

        // Standardize gender
        $gender = ucfirst(strtolower($validated['gender']));

        // Create student lead record
        $student = Student::create([
            'name' => $validated['name'],
            'father_name' => $validated['father_name'],
            'dob' => $validated['dob'],
            'phone' => $validated['phone'],
            'whatsapp_no' => $validated['whatsapp_no'],
            'qualification' => $validated['qualification'],
            'gender' => $gender,
            'address' => $validated['address'],
            'source' => 'Website Application Form',
            'status' => 'New',
            'priority' => 'Medium',
            'current_remarks' => 'Application submitted online via Udaan Foundation website.',
        ]);

        session(['student_id' => $student->id]);

        return redirect()->route('frontend.confirmation', ['id' => $student->id])->with([
            'success' => 'Your application has been successfully submitted! Our admission counselor will contact you shortly.',
            'student' => $student,
            'ref_no' => 'UDD-2025-' . str_pad($student->id, 5, '0', STR_PAD_LEFT),
        ]);
    }

    /**
     * Confirmation Page & Dynamic Allotment Letter.
     */
    public function confirmation(Request $request)
    {
        $student = null;
        $searchQuery = $request->query('search') ?? $request->query('phone') ?? $request->query('ref');

        if ($request->filled('id')) {
            $student = Student::find($request->query('id'));
        } elseif (!empty($searchQuery)) {
            $cleanQuery = preg_replace('/[^0-9]/', '', $searchQuery);
            $student = Student::where('phone', 'like', "%{$cleanQuery}%")
                ->orWhere('whatsapp_no', 'like', "%{$cleanQuery}%")
                ->orWhere('id', intval($cleanQuery))
                ->latest()
                ->first();
        } elseif (session()->has('student')) {
            $student = session('student');
        } elseif (session()->has('student_id')) {
            $student = Student::find(session('student_id'));
        } else {
            $student = Student::latest()->first();
        }

        $refNo = $student ? 'UDD-2025-' . str_pad($student->id, 5, '0', STR_PAD_LEFT) : 'UDD-2025-00001';

        return view('frontend.confirmation', compact('student', 'refNo', 'searchQuery'));
    }

    /**
     * Available Courses.
     */
    public function courses()
    {
        return view('frontend.courses');
    }

    /**
     * Process / How It Works.
     */
    public function process()
    {
        return view('frontend.process');
    }

    /**
     * Enrollment Process.
     */
    public function enrollment()
    {
        return view('frontend.enrollment');
    }

    /**
     * News & Media - Dynamic Listing & Category Filtering.
     */
    public function news(Request $request)
    {
        $selectedCategory = null;
        $searchQuery = $request->query('search');

        $query = \App\Models\Post::with(['category', 'author'])->published()->latest('published_at');

        // Category Filter
        if ($request->filled('category')) {
            $selectedCategory = \App\Models\Category::where('slug', $request->query('category'))->first();
            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        // Search Filter
        if (!empty($searchQuery)) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('excerpt', 'like', "%{$searchQuery}%")
                  ->orWhere('content', 'like', "%{$searchQuery}%");
            });
        }

        // Spotlight / Hero Featured Post (Only when on main page without filters)
        $featuredPost = null;
        if (!$request->filled('category') && empty($searchQuery) && !$request->filled('page')) {
            $featuredPost = \App\Models\Post::with(['category', 'author'])
                ->published()
                ->featured()
                ->latest('published_at')
                ->first();

            // If found, exclude from regular stream
            if ($featuredPost) {
                $query->where('id', '!=', $featuredPost->id);
            }
        }

        $posts = $query->paginate(6)->withQueryString();

        // Categories with published count
        $categories = \App\Models\Category::withCount('publishedPosts')
            ->having('published_posts_count', '>', 0)
            ->get();

        // Recent Posts for Widget
        $recentPosts = \App\Models\Post::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('frontend.news', compact('posts', 'featuredPost', 'categories', 'selectedCategory', 'searchQuery', 'recentPosts'));
    }

    /**
     * Single News Post Details.
     */
    public function newsShow($slug)
    {
        $post = \App\Models\Post::with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views counter
        $post->increment('views_count');

        // Related posts in same category
        $relatedPosts = \App\Models\Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, function ($q) use ($post) {
                $q->where('category_id', $post->category_id);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        // Categories with published count
        $categories = \App\Models\Category::withCount('publishedPosts')
            ->having('published_posts_count', '>', 0)
            ->get();

        // Recent posts
        $recentPosts = \App\Models\Post::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        return view('frontend.news-detail', compact('post', 'relatedPosts', 'categories', 'recentPosts'));
    }

    /**
     * Videos.
     */
    public function videos()
    {
        return view('frontend.videos');
    }

    /**
     * Approvals / Partners.
     */
    public function partners()
    {
        return view('frontend.partners');
    }

    /**
     * Contact Us Page.
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Store Contact Us Form Submission.
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:15',
            'email' => 'nullable|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Save as a lead in the students table
        Student::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'whatsapp_no' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'source' => 'Contact Us Page',
            'status' => 'New',
            'priority' => 'Medium',
            'current_remarks' => 'Inquiry: ' . $validated['subject'] . ' | ' . $validated['message'],
        ]);

        return redirect()->route('frontend.contact')->with('success', 'Thank you for reaching out! Our counseling team will contact you shortly.');
    }

    /**
     * Services.
     */
    public function services()
    {
        return view('frontend.services');
    }

    /**
     * Programs.
     */
    public function programs()
    {
        return view('frontend.programs');
    }
}
