<?php

namespace App\Http\Controllers;

use App\Models\Biaya;
use App\Models\User;
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    private $viewFolder = 'operator.biaya.';
    private $routePrefix = 'biaya';

    public function index(Request $request)
    {
        $search = $request->get('search');

        $biayas = Biaya::with('user')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->latest()
            ->paginate(50);

        return view($this->viewFolder . 'biaya_index', [
            'models' => $biayas,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Biaya',
        ]);
    }

    public function create()
    {
        return view($this->viewFolder . 'biaya_form', [
            'title' => 'Form Data Biaya',
            'model' => new Biaya(),
            'route' => $this->routePrefix . '.store',
            'method' => 'POST',
            'users' => User::where('akses', 'wali')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
        ]);

        Biaya::create($data);

        return redirect()->route($this->routePrefix . '.index')
            ->with('success', 'Data biaya berhasil disimpan.');
    }

    public function show(string $id)
    {
        return view($this->viewFolder . 'biaya_show', [
            'model' => Biaya::with('user')->findOrFail($id),
            'title' => 'Detail Biaya'
        ]);
    }

    public function edit(Biaya $biaya)
    {
        return view($this->viewFolder . 'biaya_edit', [
            'title' => 'Edit Data Biaya',
            'model' => $biaya,
            'route' => [$this->routePrefix . '.update', $biaya->id],
            'method' => 'PUT',
            'users' => User::where('akses', 'wali')->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Biaya $biaya)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $biaya->update($data);

        return redirect()->route($this->routePrefix . '.index')
            ->with('success', 'Data biaya berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $biaya = Biaya::findOrFail($id);
        $biaya->delete();

        return redirect()->route($this->routePrefix . '.index')
            ->with('success', 'Data biaya berhasil dihapus.');
    }
}
