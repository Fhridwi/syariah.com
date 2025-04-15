<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SantriWaliController extends Controller
{
    public function index() {
        $data['models'] = Auth::user()->santri;
        return view('wali.dataSantri.santri_index', $data);
    }
}
