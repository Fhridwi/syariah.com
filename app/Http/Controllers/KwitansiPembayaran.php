<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class KwitansiPembayaran extends Controller
{
    public function show($id) {
        $pembayaran = Pembayaran::findOrFail($id);
        $data['pembayaran' ] = $pembayaran;
        return view('operator.kwitansi.kwitansi_pembayaran', $data);
    }
}
