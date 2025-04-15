@extends('template.app')

@section('content')
    <div class="row">

    {{-- Bagian atas: Informasi Santri --}}
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                @if(!empty($data['siswa']?->foto))
                    <img src="{{ \Storage::url($data['siswa']->foto) }}" alt="{{ $data['siswa']->nama }}" width="100" class="rounded">
                @else
                    <img src="{{ asset('images/default.png') }}" alt="Default" width="100" class="rounded">
                @endif
            </div>
            <div>
                <h5 class="text-primary mb-2">
                    DATA TAGIHAN SYARIAH - 
                    {{ strtoupper(\Carbon\Carbon::create()->month($bulan ?: now()->month)->translatedFormat('F')) }} {{ $tahun ?: now()->year }}
                </h5>
                <h5 class="mb-1">{{ $data['siswa']->nama ?? '-' }}</h5>
                <p class="mb-0">NIS: {{ $data['siswa']->nis ?? '-' }}</p>
                <p class="mb-0">Kelas: {{ $data['siswa']->kelas ?? '-' }}</p>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('kartusyariah.index', [
                'santri_id' => $tagihan->santri->id, 
                'tahun' => Carbon\Carbon::now()->year
            ]) }}" class="btn btn-primary" target="_blank">
                <i class="fa fa-file"></i> Kartu Tagihan 
            </a>
            
        </div>
    </div>
</div>{{-- Bagian bawah: Flex antara Tagihan & Kartu Syariah --}}
        <div class="row mb-5">
            {{-- Kiri: DATA TAGIHAN --}}
            <div class="col-md-12 col-lg-6 mb-3">
                <div class="card">
                    <h5 class="card-header text-primary">DATA TAGIHAN</h5>
                    <div class="card-body">
                        @if($tagihan && $tagihan->tagihanDetails->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm align-middle">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th>Tagihan</th>
                                            <th class="text-end">Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tagihan->tagihanDetails as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama_biaya }}</td>
                                                <td class="text-end">Rp {{ number_format($item->jumlah_biaya, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2" class="text-end">Total Pembayaran</th>
                                            <th class="text-end">Rp {{ number_format($tagihan->tagihanDetails->sum('jumlah_biaya'), 0, ',', '.') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                             </div>
                             <h5 class="text-primary mt-4">DATA PEMBAYARAN</h5>
                        <table class="table table-striped table-sm align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th style="width: 40px;">#</th>
                                    <th>Tanggal</th>
                                    <th class="text-end">Jumlah</th>
                                    <th>Metode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tagihan->pembayaran as $item)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('kwitansipembayaran.show', $item->id ) }}" target="_blank">
                                                <i class="fa fa-print text-secondary"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d-m-Y') }}</td>
                                        <td class="text-end">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->metode_pembayaran }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        <div class="mt-3">
                            <h6 class="fw-bold">Status Pembayaran: 
                                <span class="text-success">{{ $tagihan->status }}</span>
                            </h6>
                        </div>
                         {{-- Form Pembayaran --}}
                         <h5 class="mt-4 mb-3 text-primary">FORM PEMBAYARAN</h5>
                         <form action="{{ route('pembayaran.store') }}" method="POST">
                             @csrf
                             <input type="hidden" name="tagihan_id" value="{{ $tagihan->id }}">

                             <div class="mb-3">
                                 <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                                 <input type="date"
                                     name="tanggal_bayar"
                                     id="tanggal_bayar"
                                     class="form-control"
                                     value="{{ old('tanggal_bayar', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                     required>
                             </div>

                             <div class="mb-3">
                                 <label for="jumlah_bayar" class="form-label">Jumlah Dibayarkan</label>
                                 <input type="number"
                                     name="jumlah_bayar"
                                     id="jumlah_bayar"
                                     class="form-control"
                                     placeholder="Masukkan jumlah pembayaran"
                                     required>
                             </div>

                             <div class="text-end">
                                 <button type="submit" class="btn btn-primary">Simpan</button>
                             </div>
                         </form>


                 @else
                     <div class="alert alert-info mb-0">Belum ada data tagihan tersedia.</div>
                 @endif
                        </div>
                </div>
            </div>
        </div>
@endsection
