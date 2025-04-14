<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class KartuSyariahController extends Controller
{
    public function index(Request $request) {
        $tagihan = Tagihan::where('santri_id', $request->santri_id)
        ->whereYear('tanggal_tagihan', $request->tahun)
        ->get();
        $santri = $tagihan->first()->santri;
        return view('operator.kwitansi.kartusyariah_index', [
            'tagihan'  => $tagihan,
            'santri'  => $santri
        ]);
    }
}
