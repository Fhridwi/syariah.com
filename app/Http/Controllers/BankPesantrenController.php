<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankPesantren as Model;
use App\Models\BankPesantren;
use Illuminate\Http\Request;

class BankPesantrenController extends Controller
{
    protected $viewFolder = 'operator.bank.';
    protected $routePrefix = 'bankpesantren';
    protected $title = 'BANK PESANTREN';

    protected $viewIndex = 'bankpesantren_index';
    protected $viewCreate = 'bankpesantren_form';
    protected $viewEdit = 'bankpesantren_form';

    public function index(Request $request)
    {
        $search = $request->get('search');
        $models = Model::when($search, fn($q) => $q->where('nama_rekening', 'like', "%$search%"))
            ->latest()
            ->paginate(50);

        return view("{$this->viewFolder}{$this->viewIndex}", [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => $this->title,
        ]);
    }

    public function create()
    {
        return view("{$this->viewFolder}bankpesantren_form", [
            'title' => "FORM {$this->title}",
            'model' => new BankPesantren(),
            'route' => route("{$this->routePrefix}.store"),
            'method' => 'POST',
            'listbank' => Bank::pluck('nama_bank', 'id'),
        ]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'kode',
            'nama_rekening' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
        ]);
        
        $requestData = $validated;
        $bank = Bank::find($request['bank_id']);
        $requestData['kode']    = $bank->sandi_bank;
        $requestData['nama_bank']    = $bank->nama_bank;
        

        Model::create($requestData);

        return redirect()->route("{$this->routePrefix}.index")
            ->with('success', "{$this->title} berhasil disimpan.");
    }

    public function edit(Model $model)
    {
        return view("{$this->viewFolder}{$this->viewEdit}", [
            'title' => "Edit {$this->title}",
            'model' => $model,
            'route' => route("{$this->routePrefix}.update", $model->id),
            'method' => 'PUT',
            'listbank' => Bank::pluck('nama_bank', 'id'),
        ]);
    }

    public function update(Request $request, Model $model)
    {
        $validated = $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'nama_rekening' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
        ]);

        $model->update($validated);

        return redirect()->route("{$this->routePrefix}.index")
            ->with('success', "{$this->title} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        $model->delete();

        return redirect()->route("{$this->routePrefix}.index")
            ->with('success', "{$this->title} berhasil dihapus.");
    }
}
