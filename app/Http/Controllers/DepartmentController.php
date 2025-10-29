<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('departments.index', compact('departments', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_department'  => 'required|string|max:255',
        ]);
        $department = Department::create($validated);
        if ($department) {
            return redirect()->route('departments.index')->with('success', 'Data berhasil disimpan!');
        } else {
            return back()->with('error', 'Gagal menyimpan data, coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('departments.edit', [
            'department' => Department::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_department'  => 'required|string|max:255',
        ]);
        $department = Department::findOrFail($id);
        if ($department) {
            $department->update($request->only(['nama_department']));
            return redirect()->route('departments.index')->with('success', 'Data berhasil diperbarui!');
        } else {
            return back()->with('error', 'Gagal mengubah data, coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        if ($department) {
            $department->delete();
            return redirect()->route('departments.index')->with('success', 'Data berhasil dihapus!');
        } else {
            return back()->with('error', 'Gagal menghapus data, coba lagi.');
        }
    }
}
