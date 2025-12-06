<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;

class StaffController extends Controller
{
    /**
     * Display a listing of staff members.
     * @fr FR-03: Staff Management (List View)
     */
    public function index()
    {
        $staff = Staff::all();
        return view('admin.staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new staff member.
     * @fr FR-03: Staff Management (Create Form)
     */
    public function create()
    {
        $branches = \App\Models\Branch::all();
        return view('admin.staff.create', compact('branches'));
    }

    /**
     * Store a newly created staff member in storage.
     * @fr FR-03: Staff Management (Store Logic)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        Staff::create($request->all());

        return redirect()->route('admin.staff.index')->with('success', 'Staff member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified staff member.
     * @fr FR-03: Staff Management (Edit Form)
     */
    public function edit(string $id)
    {
        $staff = Staff::findOrFail($id);
        $branches = \App\Models\Branch::all();
        return view('admin.staff.edit', compact('staff', 'branches'));
    }

    /**
     * Update the specified staff member in storage.
     * @fr FR-03: Staff Management (Update Logic)
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $staff = Staff::findOrFail($id);
        $staff->update($request->all());

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove the specified staff member from storage.
     * @fr FR-03: Staff Management (Delete Logic)
     */
    public function destroy(string $id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
