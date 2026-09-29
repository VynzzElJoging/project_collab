<?php

namespace App\Http\Controllers;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $neanganDataAnggota = $request->search;

    $anggotas = Anggota::query();

    if ($neanganDataAnggota) {
        $anggotas->where(function ($query) use ($neanganDataAnggota) {
            $query->where('nama', 'like', '%' . $neanganDataAnggota . '%')
                ->orWhere('email', 'like', '%' . $neanganDataAnggota . '%')
                ->orWhere('jenis_kelamin', 'like', '%' . $neanganDataAnggota . '%');
        });
    }

    $anggotas = $anggotas->get();

    return view('admin.data.anggota', compact(
        'anggotas',
        'neanganDataAnggota'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    return view('admin.data.anggota-create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'nullable|string|max:50',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string|max:20',
    ]);

    $validated['nama'] = trim($validated['nama']);

    if (isset($validated['email'])) {
        $validated['email'] = trim($validated['email']);
    }

    if (isset($validated['alamat'])) {
        $validated['alamat'] = trim($validated['alamat']);
    }

    if (isset($validated['no_hp'])) {
        $validated['no_hp'] = trim($validated['no_hp']);
    }

    Anggota::create($validated);

    return redirect()
        ->route('admin.data.anggota.index')
        ->with('success', 'Anggota berhasil ditambahkan.');
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
        $anggota = Anggota::findOrFail($id);

    return view('admin.data.anggota-edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'nullable|string|max:50',
        'alamat' => 'nullable|string',
        'no_hp' => 'nullable|string|max:20',
    ]);

    $anggota = Anggota::findOrFail($id);

    $validated['nama'] = trim($validated['nama']);

    if (isset($validated['email'])) {
        $validated['email'] = trim($validated['email']);
    }

    if (isset($validated['alamat'])) {
        $validated['alamat'] = trim($validated['alamat']);
    }

    if (isset($validated['no_hp'])) {
        $validated['no_hp'] = trim($validated['no_hp']);
    }

    $anggota->update($validated);

    return redirect()
        ->route('admin.data.anggota.index')
        ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);

    $anggota->delete();

    return redirect()
        ->route('admin.data.anggota.index')
        ->with('success', 'Anggota berhasil dihapus.');
    }
}
