<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of branches.
     * @fr FR-04: Branch Management (List View)
     */
    public function index()
    {
        $branches = \App\Models\Branch::all();
        return view('admin.branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new branch.
     * @fr FR-04: Branch Management (Create Form)
     */
    public function create()
    {
        return view('admin.branches.create');
    }

    /**
     * Store a newly created branch in storage.
     * @fr FR-04: Branch Management (Store Logic)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        \App\Models\Branch::create($request->all());

        return redirect()->route('admin.branches.index')->with('success', 'Branch created successfully.');
    }

    /**
     * Show the form for editing the specified branch.
     * @fr FR-04: Branch Management (Edit Form)
     */
    public function edit(string $id)
    {
        $branch = \App\Models\Branch::findOrFail($id);
        return view('admin.branches.edit', compact('branch'));
    }

    /**
     * Update the specified branch in storage.
     * @fr FR-04: Branch Management (Update Logic)
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $branch = \App\Models\Branch::findOrFail($id);
        $branch->update($request->all());

        return redirect()->route('admin.branches.index')->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified branch from storage.
     * @fr FR-04: Branch Management (Delete Logic)
     */
    public function destroy(string $id)
    {
        $branch = \App\Models\Branch::findOrFail($id);
        $branch->delete();

        return redirect()->route('admin.branches.index')->with('success', 'Branch deleted successfully.');
    }
}
