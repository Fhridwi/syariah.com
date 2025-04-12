<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User as Model;

class UserController extends Controller
{

    private $viewIndex = 'user_index' ;
    private $viewCreate = 'user_form' ;
    private $viewEdit = 'user_edit' ;
    private $viewShow = 'user_show' ;
    private $routePrefix = 'user';

 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('operator.dataUser.'.$this->viewIndex, [
            'models' => Model::where('akses', '<>', 'wali')
                ->latest()
                ->paginate(50),
                  'routePrefix' => $this->routePrefix,
            'title' => 'Data User '
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix.'.store',
            'button' => 'SIMPAN',
            'title' => 'Form Data User'
        ];
        return view('operator.dataUser.' .$this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nohp' => 'required|string|max:20',
            'akses' => 'required|in:admin,operator,wali',
            'password' => 'required|string|min:6'
        ]);
    
        // Simpan user baru
        $requestData['password'] = bcrypt('defaultpassword');  
        Model::create($requestData);
    
        return redirect()->route($this->routePrefix . '.index')->with('success', 'Data user berhasil disimpan.');
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
    $data = [
        'model'  => \App\Models\User::findOrFail($id),
        'method' => 'PUT',
        'route'  => ['user.update', $id], 
        'button' => 'UPDATE',
        'title'  => 'Edit User'

    ];
    return view('operator.dataUser.'. $this->viewEdit, $data);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $user = \App\Models\User::findOrFail($id);

    $requestData = $request->validate([
        'name'   => 'required|string|max:255',
        'email'  => 'required|email|unique:users,email,' . $id,
        'nohp'   => 'required|string|max:20',
        'akses'  => 'required|in:admin,operator,wali',
        'password' => 'nullable|string|min:6'
    ]);

    
    if (!empty($requestData['password'])) {
        $requestData['password'] = bcrypt($requestData['password']);
    } else {
        unset($requestData['password']); 
    }

    $user->update($requestData);

    return redirect()->route($this->routePrefix.'.index')->with('success', 'Data user berhasil diperbarui.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cek jika ID yang akan dihapus adalah ID 1
        if ($id == 1) {
            return redirect()->route($this->routePrefix.'.index')->with('error', 'Data tidak bisa dihapus.');
        }
    
        // Cari data user berdasarkan ID
        $user = \App\Models\User::findOrFail($id);
    
        // Hapus data user
        $user->delete();
    
        // Redirect ke halaman user.index dengan pesan sukses
        return redirect()->route($this->routePrefix.'.index')->with('success', 'Data user berhasil dihapus.');
    }
    
    
}
