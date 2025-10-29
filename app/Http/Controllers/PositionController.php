<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::all();
        $departments = Department::all();
        return view('positions.index', compact('positions', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan'  => 'required|string|max:255',
            'gaji_pokok'    => 'required|decimal:0,2',
        ]);
        Position::create($request->all());
        return redirect()->route('positions.index');
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
        return view('positions.edit', [
            'position' => Position::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_jabatan'  => 'required|string|max:255',
            'gaji_pokok'    => 'required|decimal:0,2',
        ]);
        $position = Position::findOrFail($id);
        if ($position) {
            $position->update($request->only([
                'nama_jabatan',
                'gaji_pokok',
            ]));
            return redirect()->route('positions.index')->with('success', 'Data berhasil diperbarui!');
        } else {
            return back()->with('error', 'Gagal memperbarui data, coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Position::findOrFail($id);
        if ($position) {
            $position->delete();
            return redirect()->route('positions.index')->with('success', 'Data berhasil dihapus!');
        } else {
            return back()->with('error', 'Gagal menghapus data, coba lagi.');
        }
    }
}
