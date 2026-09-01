<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::all();
        return view('artikel', compact('artikels'));
    }

    // 1. Menampilkan halaman form
    public function create()
    {
        return view('tambah_artikel');
    }

    // 2. Memproses & menyimpan data dari form
    public function store(Request $request)
    {
        $request->validate([
            'judul'  => 'required|min:5',
            'isi'    => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Max 2MB
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke folder storage/app/public/artikels
            $namaGambar = $request->file('gambar')->store('artikels', 'public');
        }

        Artikel::create([
            'judul'  => $request->judul,
            'isi'    => $request->isi,
            'gambar' => $namaGambar
        ]);

        return redirect('/artikel')->with('sukses', 'Artikel berhasil ditambahkan!');
    }

    // 3. Tampilkan form edit
    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('edit_artikel', compact('artikel'));
    }

    // 4. Simpan perubahan data
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'  => 'required|min:5',
            'isi'    => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $artikel = Artikel::findOrFail($id);
        $namaGambar = $artikel->gambar;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            // Simpan gambar baru
            $namaGambar = $request->file('gambar')->store('artikels', 'public');
        }

        $artikel->update([
            'judul'  => $request->judul,
            'isi'    => $request->isi,
            'gambar' => $namaGambar
        ]);

        return redirect('/artikel')->with('sukses', 'Artikel berhasil diperbarui!');
    }

    // 5. Hapus data dari database
    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);

        // Hapus file gambar dari penyimpanan saat artikel dihapus
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $artikel->delete();

        return redirect('/artikel')->with('sukses', 'Artikel berhasil dihapus!');
    }
}