<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    public function index()
    {
        $biodatas = Biodata::all();
        return view('welcome', compact('biodatas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'nim'       => 'nullable|string|max:50',
            'deskripsi' => 'required|string',
            'foto'      => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('biodata-foto', 'public');
        }

        Biodata::create([
            'nama'      => $request->nama,
            'nim'       => $request->nim,
            'deskripsi' => $request->deskripsi,
            'foto'      => $pathFoto,
        ]);

        return redirect()->route('biodata.index')->with('success', 'Biodata berhasil ditambahkan.');
    }

    public function update(Request $request, Biodata $biodata)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'nim'       => 'nullable|string|max:50',
            'deskripsi' => 'required|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'nama'      => $request->nama,
            'nim'       => $request->nim,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            if ($biodata->foto) {
                Storage::disk('public')->delete($biodata->foto);
            }
            $data['foto'] = $request->file('foto')->store('biodata-foto', 'public');
        }

        $biodata->update($data);

        return redirect()->route('biodata.index')->with('success', 'Biodata berhasil diperbarui.');
    }

    public function destroy(Biodata $biodata)
    {
        if ($biodata->foto) {
            Storage::disk('public')->delete($biodata->foto);
        }

        $biodata->delete();

        return redirect()->route('biodata.index')->with('success', 'Biodata berhasil dihapus.');
    }
}