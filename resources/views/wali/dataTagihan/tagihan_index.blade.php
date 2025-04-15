@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">DATA TAGIHAN WALI SANTRI</h5>

                    <div class="table-responsive table-responsive-sm table-responsive-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Program</th>
                                    <th>Angkatan</th>
                                    <th>Tanggal Tagihan</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->santri->nama }}</td>
                                        <td>{{ $item->santri->program }}</td>
                                        <td>{{ $item->santri->angkatan }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_tagihan)->format('F Y') }}</td>
                                        <td>
                                            <span class="badge {{ $item->getStatusTagihanWali() == 'Belum Dibayar' ? 'bg-danger' : 'bg-success' }}">
                                                {{ $item->getStatusTagihanWali() }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($item->status == 'baru' || $item->status == 'angsuran')
                                                <a href="{{ route('wali.tagihan.show', $item->id) }}" class="btn btn-sm btn-primary">Bayar</a>
                                            @else
                                                <span class="badge bg-success">Sudah Lunas</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection