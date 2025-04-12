<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    private $viewIndex = 'santri_index';
    private $viewCreate = 'santri_form';
    private $viewEdit = 'santri_edit';
    private $viewShow = 'santri_show';
    private $routePrefix = 'santri';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $santris = Santri::search($search)
                         ->latest()
                         ->paginate(50);

        return view('operator.dataSantri.' . $this->viewIndex, [
            'models' => $santris,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Santri',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Form Data Santri',
            'model' => new Santri(),
            'route' => $this->routePrefix . '.store',
            'method'=> 'POST',
            'wali'  => User::where('akses', 'wali')->pluck('name', 'id'),
        ];

        $users = User::where('akses', 'wali')->pluck('name', 'id');
        $data['users'] = $users;
    

        return view('operator.dataSantri.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'wali_id' => 'nullable|exists:users,id',
            'wali_status' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:santris,nis',
            'program' => 'required|string|max:100',
            'angkatan' => 'required|string|max:10',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5000',
        ]);
    
        // Simpan file foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $hashedName = $foto->hashName();
            $foto->storeAs('public/foto', $hashedName);
            $requestData['foto'] = 'foto/' . $hashedName;
        }
    
        // Default wali
        $requestData['user_id'] = $request->wali_id;
    
        if (empty($requestData['wali_id'])) {
            $requestData['wali_id'] = null;
            $requestData['wali_status'] = null;
        } else {
            $requestData['wali_status'] = $requestData['wali_status'] ?? 'ok';
        }
    
        Santri::create($requestData);
    
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data santri berhasil disimpan.');
    }

    public function show(string $id)
    {
        return view('operator/dataSantri.' . $this->viewShow, [
            'model' => Santri::findOrFail($id),
            'title' => 'Detail Santri'
        ]);
    }
    

    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Santri $santri)
    {
        $data = [
            'title' => 'Edit Data Santri',
            'model' => $santri,
            'route' => [$this->routePrefix . '.update', $santri->id],
            'method' => 'PUT',
            'wali'  => User::where('akses', 'wali')->pluck('name', 'id'),           
        ];
        $users = User::where('akses', 'wali')->pluck('name', 'id');
        $data['users'] = $users;

        return view('operator.dataSantri.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Santri $santri)
{
    $requestData = $request->validate([
        'wali_id' => 'nullable|exists:users,id',
        'wali_status' => 'nullable|string|max:50',
        'nama' => 'required|string|max:255',
        'nis' => 'required|string|max:50|unique:santris,nis,' . $santri->id,
        'program' => 'required|string|max:100',
        'angkatan' => 'required|string|max:10',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5000',
    ]);

    // Simpan file baru jika ada
    if ($request->hasFile('foto')) {
        $foto = $request->file('foto');
        $hashedName = $foto->hashName();
        $foto->storeAs('public/foto', $hashedName);
        $requestData['foto'] = 'foto/' . $hashedName;
    } else {
        // Jika tidak ada file baru dan sebelumnya ada, gunakan yang lama
        $requestData['foto'] = $santri->foto ?? null;
    }

    if (empty($requestData['wali_id'])) {
        $requestData['wali_id'] = null;
        $requestData['wali_status'] = null;
    } else {
        $requestData['wali_status'] = $requestData['wali_status'] ?? 'ok';
    }

    $santri->update($requestData);

    return redirect()->route($this->routePrefix . '.index')->with('success', 'Data santri berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $santri = Santri::findOrFail($id);
        
        // Jika ada foto, hapus dari storage
        if ($santri->foto) {
            Storage::delete($santri->foto);
        }

        $santri->delete();

        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data santri berhasil dihapus.');
    }
}
