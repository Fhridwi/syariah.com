@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-primary mb-4">
                        <i class="fa fa-file-invoice-dollar me-2"></i>
                        TAGIHAN PEMBAYARAN
                    </h5>
                    <div class="table-responsive">
                        <div class="row">
                            {{-- Bagian Kiri: Info Santri + Foto --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="col-12 mb-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body d-flex align-items-start">
                                            <div class="me-4">
                                                @if(!empty($santri->foto))
                                                    <img src="{{ \Storage::url($santri->foto) }}" alt="{{ $santri->nama }}" width="100" class="rounded shadow-sm">
                                                @else
                                                    <img src="{{ asset('images/default.png') }}" alt="Default" width="100" class="rounded shadow-sm">
                                                @endif
                                            </div>
                        
                                            <div class="table-responsive w-100">
                                                <table class="table table-borderless table-sm">
                                                    <tr>
                                                        <th style="width: 150px;">Nama</th>
                                                        <td>: {{ strtoupper($santri->nama ?? '-') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>NIS</th>
                                                        <td>: {{ $santri->nis ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Program</th>
                                                        <td>: {{ $santri->program ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tahun Ajaran</th>
                                                        <td>: {{ $santri->angkatan ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Wali Santri</th>
                                                        <td>: {{ $santri->user->name ?? '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            {{-- Bagian Kanan: Info Tagihan --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="col-12 mb-4">
                                    <div class="card shadow-sm border-0">
                                        <div class="card-body">
                                            <h6 class="text-primary mb-3">
                                                <i class="fa fa-file-invoice-dollar me-1"></i> Informasi Tagihan
                                            </h6>
                                            <table class="table table-borderless table-sm">
                                                <tr>
                                                    <th style="width: 160px;">Nomor Tagihan</th>
                                                    <td>: #SYARIAH{{ $tagihan->id ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Tagihan</th>
                                                    <td>: {{ \Carbon\Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat('d F Y') ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Terakhir</th>
                                                    <td>: {{ \Carbon\Carbon::parse($tagihan->tanggal_jatuh_tempo)->translatedFormat('d F Y') ?? '-' }}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th>Status </th>
                                                    <td>
                                                        : 
                                                        @if ($tagihan->status === 'lunas')
                                                            <span class="badge bg-success">Lunas</span>
                                                        @elseif ($tagihan->status === 'menunggu')
                                                            <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                                        @elseif ($tagihan->status === 'cicilan')
                                                            <span class="badge bg-info text-dark">Cicilan</span>
                                                        @else
                                                            <span class="badge bg-danger">Belum Dibayar</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                            @if ($tagihan->status == 'lunas')
                                            <a href="" target="_blank" class="btn btn-sm btn-primary mt-2">
                                                <i class="bi bi-printer"></i> Cetak Invoice
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <table class="table table-hover table-bordered table-sm align-middle">
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
                                <tr class="table-light">
                                    <th colspan="2" class="text-center fw-bold">Total Pembayaran</th>
                                    <th class="text-end fw-bold text-success">
                                        Rp {{ number_format($tagihan->tagihanDetails->sum('jumlah_biaya'), 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="alert alert-secondary mt-4 d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <i class="fa fa-info-circle me-2 text-primary"></i>
                            Pembayaran bisa dilakukan secara langsung ke bendahara pondok atau transfer melalui rekening berikut:
                        </div>
                        <div class="mt-2 mt-md-0">
                            <a href="" class="btn btn-link text-decoration-underline">
                                📋 Tata Cara Transfer (M-Banking / ATM) - Klik di sini
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        @forelse ($bankpesantren as $itemBank)
                            <div class="col-md-6 mb-3">
                                <div class="card border-primary h-100 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="text-uppercase text-primary">
                                            <i class="fa fa-university me-1"></i>{{ $itemBank->nama_bank }}
                                        </h6>
                                        <p class="mb-1"><strong>Nomor Rekening:</strong><br> {{ $itemBank->nomor_rekening }}</p>
                                        <p class="mb-2"><strong>Atas Nama:</strong><br> {{ $itemBank->nama_rekening }}</p>

                                        <a href=""
                                            class="btn btn-sm btn-success mt-2">
                                            <i class="fa fa-check-circle me-1"></i> Konfirmasi Pembayaran
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning">Belum ada informasi rekening tersedia.</div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
