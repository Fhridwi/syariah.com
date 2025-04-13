<?php

namespace App\Http\Controllers;

use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\Biaya;
use App\Models\Santri;
use App\Models\Tagihan;
use Carbon\Carbon;
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
        $tahun = $request->get('tahun');
$bulan = $request->get('bulan');

$tagihans = Tagihan::with('user', 'santri')
    ->when($tahun, function ($query) use ($tahun) {
        $query->whereYear('tanggal_tagihan', $tahun);
    })
    ->when($bulan, function ($query) use ($bulan) {
        $query->whereMonth('tanggal_tagihan', $bulan);
    })
    ->groupBy('santri_id')
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
           'biaya' => \App\Models\Biaya::all()->mapWithKeys(function ($item) {
    return [$item->id => $item->nama . ' - Rp' . number_format($item->jumlah, 0, ',', '.')];
}),

        ]);
    }
    
    
    public function store(StoreTagihanRequest $request)
{
    // validasi data
    $requestData = $request->validated();

    // ambil ID biaya yang dipilih
    $biayaIdArray = $requestData['jumlah_biaya'];

    // ambil data santri berdasarkan angkatan
    $santri = Santri::query();

    if ($requestData['angkatan']) {
        $santri->where('angkatan', $requestData['angkatan']);
    }

    $santri = $santri->get();

    foreach($santri as $item) {
        $itemSantri = $item;
        $biaya = Biaya::whereIn('id', $biayaIdArray)->get();
        foreach($biaya as $itemBiaya) {
            $dataTagihan = [
                'santri_id'     => $itemSantri->id,
                'angkatan'      => $requestData['angkatan'],
                // 'program'       => $requestData['program'],
                'tanggal_tagihan'=>  $requestData['tanggal_tagihan'],
                'tanggal_jatuh_tempo'=>  $requestData['tanggal_jatuh_tempo'],
                'nama_biaya'      => $itemBiaya->nama,
                'jumlah_biaya'  => $itemBiaya->jumlah,
                'keterangan'      => $requestData['keterangan'],
                'status'        => 'baru'
            ];
           
            $tanggalJatuhTempo = Carbon::parse($requestData['tanggal_jatuh_tempo']);
            $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
            $bulanTagihan = $tanggalTagihan->format('m');
            $tahunTagihan = $tanggalTagihan->format('Y');
            $cekTagihan = Model::where('santri_id', $itemSantri->id)
                    ->where( 'nama_biaya', $itemBiaya->nama)
                    ->whereMonth('tanggal_tagihan', $bulanTagihan)
                    ->whereYear('tanggal_tagihan', $tahunTagihan)
                    ->first();

                if($cekTagihan == null) {
                    Model::create($dataTagihan);
                }
        }
    }
    return redirect()->route('tagihan.index')->with('success', 'Data tagihan berhasil disimpan.');
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
