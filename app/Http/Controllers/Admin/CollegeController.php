<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    /**
     * Display a listing of colleges.
     */
    public function index(Request $request)
    {
        $query = College::withCount('studentBills')->latest();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('affiliation', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $colleges = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => College::count(),
            'active' => College::where('is_active', true)->count(),
            'inactive' => College::where('is_active', false)->count(),
        ];

        return view('admin.colleges.index', compact('colleges', 'stats'));
    }

    /**
     * Store a newly created college in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'affiliation' => 'nullable|string|max:150',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'website' => 'nullable|string|max:200',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['state'] = $validated['state'] ?? 'Bihar';

        $college = College::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'College added successfully!',
                'college' => $college,
            ]);
        }

        return redirect()->route('admin.colleges.index')->with('success', "College '{$college->name}' created successfully!");
    }

    /**
     * Update the specified college in storage.
     */
    public function update(Request $request, College $college)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'affiliation' => 'nullable|string|max:150',
            'contact_person' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'website' => 'nullable|string|max:200',
            'is_active' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $college->update($validated);

        return redirect()->route('admin.colleges.index')->with('success', "College '{$college->name}' updated successfully!");
    }

    /**
     * Remove the specified college from storage.
     */
    public function destroy(College $college)
    {
        $name = $college->name;
        $college->delete();

        return redirect()->route('admin.colleges.index')->with('success', "College '{$name}' deleted successfully!");
    }
}
