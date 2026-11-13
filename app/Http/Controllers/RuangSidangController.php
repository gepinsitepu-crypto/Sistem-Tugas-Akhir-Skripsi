<?php

namespace App\Http\Controllers;

use App\Models\RuangSidang;
use Illuminate\Http\Request;

class RuangSidangController extends Controller
{
    public function index()
    {
        $ruangan = RuangSidang::orderBy('id', 'desc')->get();
        return view('ruang_sidang.index', compact('ruangan'));
    }

    public function create()
    {
        return view('ruang_sidang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_ruangan' => 'required',
            'nama_gedung' => 'required',
            'kapasitas' => 'required|numeric',
            'status_ruangan' => 'required',
        ]);

        $fasilitas = $request->has('fasilitas') ? implode(", ", $request->fasilitas) : "-";

        RuangSidang::create([
            'kode_ruangan' => $request->kode_ruangan,
            'nama_gedung' => $request->nama_gedung,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $fasilitas,
            'status_ruangan' => $request->status_ruangan,
        ]);

        return redirect()->route('ruang-sidang.index')->with('success', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        $data = RuangSidang::findOrFail($id);
        $fasilitas_array = explode(", ", $data->fasilitas);
        return view('ruang_sidang.edit', compact('data', 'fasilitas_array'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_ruangan' => 'required',
            'nama_gedung' => 'required',
            'kapasitas' => 'required|numeric',
            'status_ruangan' => 'required',
        ]);

        $ruangan = RuangSidang::findOrFail($id);
        $fasilitas_baru = $request->has('fasilitas') ? implode(", ", $request->fasilitas) : "-";

        $ruangan->update([
            'kode_ruangan' => $request->kode_ruangan,
            'nama_gedung' => $request->nama_gedung,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $fasilitas_baru,
            'status_ruangan' => $request->status_ruangan,
        ]);

        return redirect()->route('ruang-sidang.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $ruangan = RuangSidang::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('ruang-sidang.index')->with('success', 'Data berhasil dihapus!');
    }
}