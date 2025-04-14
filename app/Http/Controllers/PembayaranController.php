<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Tagihan;

class PembayaranController extends Controller
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
    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
    
        // Default metode dan status konfirmasi
        $requestData['status_konfirmasi'] = 'sudah';
        $requestData['metode_pembayaran'] = 'manual';
    
        // Ambil tagihan
        $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
        $totalTagihan = $tagihan->tagihanDetails->sum('jumlah_biaya');
    
        // Simpan pembayaran terlebih dahulu
        $pembayaranBaru = Pembayaran::create($requestData);
    
        // Hitung total seluruh pembayaran (termasuk yang baru saja disimpan)
        $totalDibayar = $tagihan->pembayaran()->sum('jumlah_bayar');
    
        // Update status tagihan berdasarkan total yang dibayar
        if ($totalDibayar >= $totalTagihan) {
            $tagihan->status = 'lunas';
        } else {
            $tagihan->status = 'angsuran';
        }
    
        $tagihan->save();
    
        return redirect()->back()->with('success', 'Pembayaran berhasil disimpan.');
    }
    

    

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
