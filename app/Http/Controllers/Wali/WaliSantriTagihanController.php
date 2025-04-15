<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliSantriTagihanController extends Controller
{
    public function index() 
    {
        $santriId = Auth()->user()->santri->pluck('id');
        $data['tagihan'] = Tagihan::whereIn('santri_id', $santriId)->get();
        return view('wali.dataTagihan.tagihan_index', $data);
    }
}
