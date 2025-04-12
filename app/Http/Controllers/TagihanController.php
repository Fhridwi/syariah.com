<?php

namespace App\Http\Controllers;

use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\Biaya;
use App\Models\Santri;
use Illuminate\Http\Request;

class TagihanController extends Controller
{

    private $viewFolder = 'operator.dataTagihan.';
    private $routePrefix = 'tagihan';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->get('search');

    $tagihans = Model::with('user', 'santri')
        ->when($search, function ($query, $search) {
            $query->where('nama', 'like', "%$search%");
        })
        ->latest()
        ->paginate(50);

    return view($this->viewFolder . 'tagihan_index', [
        'models' => $tagihans,
        'routePrefix' => $this->routePrefix,
        'title' => 'Data Tagihan',
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->viewFolder . 'tagihan_form', [
            'santris' => \App\Models\Santri::pluck('nama', 'id'),
            'users' => \App\Models\User::pluck('name', 'id'),
            'title' => 'Tambah Tagihan',
            'route' => route($this->routePrefix . '.store'), 
            'method' => 'POST', 
            'button' => 'Simpan',
            'angkatan'  => Santri::pluck('angkatan', 'angkatan'),
            'program'   => Santri::pluck('program', 'program'),
            'biaya'     => Biaya::pluck('nama', 'id')
        ]);
    }
    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required',
            'user_id' => 'required',
            'angkatan' => 'required|integer',
            'program' => 'required|integer',
            'tanggal_tagihan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'nama_biaya' => 'required|string',
            'jumlah_biaya' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'denda' => 'required|numeric',
            'status' => 'required|in:baru,angsuran,lunas',
        ]);
    
        Model::create($validated);
    
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data tagihan berhasil disimpan.');
    }
    
    public function show($id)
    {
        $model = Model::with(['user', 'santri'])->findOrFail($id);
    
        return view($this->viewFolder . 'tagihan_show', compact('model') + [
            'title' => 'Detail Tagihan',
            'routePrefix' => $this->routePrefix,
        ]);
    }
    
    public function edit($id)
    {
        $model = Model::findOrFail($id);
    
        return view($this->viewFolder . 'tagihan_edit', [
            'model' => $model,
            'santris' => \App\Models\Santri::pluck('nama', 'id'),
            'users' => \App\Models\User::pluck('name', 'id'),
            'title' => 'Edit Tagihan',
            'routePrefix' => $this->routePrefix,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $model = Model::findOrFail($id);
    
        $validated = $request->validate([
            'santri_id' => 'required',
            'user_id' => 'required',
            'angkatan' => 'required|integer',
            'program' => 'required|integer',
            'tanggal_tagihan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'nama_biaya' => 'required|string',
            'jumlah_biaya' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'denda' => 'required|numeric',
            'status' => 'required|in:baru,angsuran,lunas',
        ]);
    
        $model->update($validated);
    
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data tagihan berhasil diperbarui.');
    }
    
    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        $model->delete();
    
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data tagihan berhasil dihapus.');
    }
    
}
