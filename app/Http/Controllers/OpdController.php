<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $opds = Opd::all(); // Assuming you have an Opd model
        return view('opds.index', compact('opds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('opds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:opds,name|string|max:255',
        ]);

        do {
            $kode = mt_rand(10000000, 99999999);
        } while (Opd::where('kode', $kode)->exists());


        Opd::create([
            'name' => $validated['name'],
            'kode' => $kode,
        ]);

        return redirect()->route('opds.index')->with('success', 'OPD berhasil ditambahkan.');
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
        $opd = Opd::findOrFail($id);
        return view('opds.edit', compact('opd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $opd = Opd::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|unique:opds,name,' . $opd->id . '|string|max:255',
            'kode' => 'nullable|string|max:255',
        ]);

        $opd->update($validated);

        return redirect()->route('opds.index')->with('success', 'OPD berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $opd = Opd::findOrFail($id);
        $opd->delete();

        return redirect()->route('opds.index')->with('success', 'OPD berhasil dihapus.');
    }
}
