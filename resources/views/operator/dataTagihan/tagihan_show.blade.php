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
                            {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                        </h5>
                        <h5 class="mb-1">{{ $data['siswa']->nama ?? '-' }}</h5>
                        <p class="mb-0">NIS: {{ $data['siswa']->nis ?? '-' }}</p>
                        <p class="mb-0">Kelas: {{ $data['siswa']->kelas ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian bawah: Flex antara Tagihan & Kartu Syariah --}}
        <div class="row mb-5">
            
            {{-- Kiri: DATA TAGIHAN --}}
            <div class="col-md-12 col-lg-6 mb-3">
                <div class="card">
                    <h5 class="card-header text-primary">DATA TAGIHAN</h5>
                    <div class="card-body">
                        @if($tagihan && $tagihan->tagihanDetails->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tagihan</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tagihan->tagihanDetails as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama_biaya }}</td>
                                                <td>Rp {{ number_format($item->jumlah_biaya, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total Pembayaran</td>
                                            <td>Rp {{ number_format($tagihan->tagihanDetails->sum('jumlah_biaya'), 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TANGGAL</th>
                                            <th>JUMLAH</th>
                                            <th>METODE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tagihan->pembayaran as $item)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('kwitansipembayaran.show', $item->id ) }}" target="_blank"> <i class="fa fa-print"></i> </a>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d-m-Y') }}</td>
                                                <td>{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                                <td>{{ $item->metode_pembayaran }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <h5>Status Pembayaran: {{ $tagihan->status }}</h5>
                            </div>

                            {{-- Form Pembayaran --}}
                            <h5 class="card-header text-primary">DATA TAGIHAN</h5>
                            
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
                            
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>

                        @else
                            <div class="alert alert-info mb-0">Belum ada data tagihan tersedia.</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kanan: KARTU SYARIAH --}}
            <div class="col-md-12 col-lg-6 mb-3">
                <div class="card border">
                    <h5 class="card-header text-primary">KARTU SYARIAH</h5>
                    <div class="card-body">
                        <ul>
                            <li>Info infaq</li>
                            <li>Donasi</li>
                            <li>Laporan spiritual</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
