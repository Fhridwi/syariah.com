<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use \App\Models\User as Model;

class WaliController extends Controller
{

    private $viewIndex = 'wali_index' ;
    private $viewCreate = 'user_form' ;
    private $viewEdit = 'user_edit' ;
    private $viewShow = 'wali_show' ;
    private $routePrefix = 'wali';

 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('operator.dataWali.'.$this->viewIndex, [
            'models' => Model::where('akses', 'wali')
                ->latest()
                ->paginate(50),
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Wali Santri'
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
            'title' => 'Form Data Wali Santri'
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
        'password' => 'required|string|min:6'
    ]);

    $requestData['password'] = bcrypt($requestData['password']);
    $requestData['email_verified_at'] = now();  
    $requestData['akses'] = 'wali';   

    Model::create($requestData);

    return redirect()->route($this->routePrefix . '.index')->with('success', 'Data wali berhasil disimpan.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('operator.dataWali.'.$this->viewShow, [
            'santri' => Santri::whereNull('wali_id')->pluck('nama', 'id'),
'model' => Model::with('santri')
    ->where('akses', 'wali')
    ->where('id', $id)
    ->firstOrFail(),
            'title' => 'Detail Data Wali Santri',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'model'  => Model::findOrFail($id),
            'method' => 'PUT',
            'route'  => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'title'  => 'Edit Wali Santri'
        ];
        return view('operator.dataUser.' . $this->viewEdit, $data);
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
    $model = Model::where('id', $id)->where('akses', 'wali')->firstOrFail();
    $model->delete();

    return redirect()->route($this->routePrefix . '.index')->with('success', 'Data wali berhasil dihapus.');
}

    
    
}
