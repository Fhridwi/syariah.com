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
        <div class="col-12">
            <div class="d-flex flex-wrap gap-4">

                {{-- Kiri: Tabel Tagihan --}}
                <div class="flex-fill" style="min-width: 60%">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Daftar Tagihan</h5>

                            @if($bulan && $tahun)
                                <p class="text-muted">Tagihan bulan
                                    <strong>{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}</strong> tahun
                                    <strong>{{ $tahun }}</strong>.
                                </p>
                            @endif

                            @if ($tagihan->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Biaya</th>
                                                <th>Nominal</th>
                                                <th>Status</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tagihan as $key => $item)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->nama_biaya }}</td>
                                                    <td>Rp {{ number_format($item->jumlah_biaya, 0, ',', '.') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $item->status == 'Lunas' ? 'success' : 'warning' }}">
                                                            {{ ucfirst(strtolower($item->status)) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_tagihan)->format('d-m-Y') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info mt-3">
                                    Tidak ada tagihan pada bulan dan tahun yang dipilih.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kanan: Kartu Syariah --}}
                <div class="flex-grow-1" style="min-width: 35%">
                    <div class="card border border-success">
                        <div class="card-body">
                            <h5 class="card-title text-success">Kartu Syariah</h5>
                            <p class="text-muted">Fitur syariah atau informasi lainnya ditaruh di sini...</p>
                            <ul>
                                <li>Info infaq</li>
                                <li>Donasi</li>
                                <li>Laporan spiritual</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <a href="{{ route('tagihan.index') }}" class="btn btn-secondary mt-4">
                <i class="bx bx-arrow-back"></i> Kembali
            </a>
        </div>
    </div>
@endsection
