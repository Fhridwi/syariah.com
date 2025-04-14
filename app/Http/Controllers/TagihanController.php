<?php

namespace App\Http\Controllers;

use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\Biaya;
use App\Models\Pembayaran;
use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\TagihanDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $tagihans = Tagihan::with(['user', 'santri', 'tagihanDetail'])
        ->when($tahun, fn($q) => $q->whereYear('tanggal_tagihan', $tahun))
        ->when($bulan, fn($q) => $q->whereMonth('tanggal_tagihan', $bulan))
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
        $requestData = $request->validated();
        $biayaList = Biaya::whereIn('id', $requestData['jumlah_biaya'])->get();

        $santri = Santri::query();
        if ($requestData['angkatan']) {
            $santri->where('angkatan', $requestData['angkatan']);
        }
        $santri = $santri->get();

        if ($santri->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada santri ditemukan untuk angkatan tersebut.');
        }

        $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
        $bulanTagihan = $tanggalTagihan->format('m');
        $tahunTagihan = $tanggalTagihan->format('Y');

        DB::beginTransaction();
        try {
            foreach ($santri as $itemSantri) {
                $cekTagihan = Tagihan::where('santri_id', $itemSantri->id)
                    ->whereMonth('tanggal_tagihan', $bulanTagihan)
                    ->whereYear('tanggal_tagihan', $tahunTagihan)
                    ->first();

                if (!$cekTagihan) {
                    $tagihan = Tagihan::create([
                        'santri_id'     => $itemSantri->id,
                        'angkatan'      => $requestData['angkatan'],
                        'tanggal_tagihan' => $requestData['tanggal_tagihan'],
                        'tanggal_jatuh_tempo' => $requestData['tanggal_jatuh_tempo'],
                        'keterangan'    => $requestData['keterangan'],
                        'status'        => 'baru'
                    ]);

                    foreach ($biayaList as $biaya) {
                        TagihanDetail::create([
                            'tagihan_id'    => $tagihan->id,
                            'nama_biaya'    => $biaya->nama,
                            'jumlah_biaya'  => $biaya->jumlah,
                        ]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('tagihan.index')->with('success', 'Data tagihan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data tagihan.');
        }
    }



    public function show($id, Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $tagihan = Model::with(['user', 'santri','tagihanDetails', 'pembayaran'])
            ->where('santri_id', $id)
            ->when($bulan, fn($q) => $q->whereMonth('tanggal_tagihan', $bulan))
            ->when($tahun, fn($q) => $q->whereYear('tanggal_tagihan', $tahun))
            ->first();
            $data['model'] = new Pembayaran();

        return view($this->viewFolder . 'tagihan_show', [
            'title' => 'Detail Tagihan',
            'routePrefix' => $this->routePrefix,
            'tagihan' => $tagihan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data'  => $data,
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
