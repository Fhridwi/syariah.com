<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;

class WaliSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'wali_id' => 'required|integer|exists:users,id',
            'santri_id' => 'required|integer|exists:santris,id',
        ]);
        
    
        // Cek apakah Wali dan Santri ada di database
        $wali = User::find($request->wali_id);
        $santri = Santri::find($request->santri_id);
    
        // Pastikan objek ditemukan
        if (!$wali || !$santri) {
            return redirect()->back()->with('error', 'Wali atau Santri tidak ditemukan.');
        }
    
        // Menetapkan status wali pada santri
        $santri->wali_status = 'ok';
        $santri->wali_id = $wali->id;

    
        // Cek apakah berhasil disimpan
        if ($santri->save()) {
            return redirect()->back()->with('success', 'Data wali berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data wali.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Cari data santri berdasarkan ID
    $santri = Santri::findOrFail($id);

    // Hapus relasi wali dari santri
    $santri->wali_id = null;
    $santri->wali_status = null;

    // Simpan perubahan
    if ($santri->save()) {
        return redirect()->back()->with('success', 'Relasi wali santri berhasil dihapus.');
    } else {
        return redirect()->back()->with('error', 'Gagal menghapus relasi wali santri.');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
