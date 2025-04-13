@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus"></i> Tambah Data
                        </a>

                        {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET', 'class' => 'd-flex']) !!}
                        <div class="row w-100">
                            <div class="col">
                                {!! Form::select('tahun', range(date('Y'), 2020), request('tahun'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Pilih Tahun'
                                ]) !!}
                            </div>
                            <div class="col">
                                {!! Form::select('bulan', [
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Maret',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Juni',
                                    '07' => 'Juli',
                                    '08' => 'Agustus',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember'
                                ], request('bulan'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Pilih Bulan'
                                ]) !!}
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="bx bx-search"></i> Filter
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    
                    </div>


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>nis</th>
                                    <th>Nama Biaya</th>
                                    <th>Jumlah</th>
                                    <th>Santri</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->santri->nis }}</td>
                                        <td>{{ $item->nama_biaya }}</td>
                                        <td>Rp {{ number_format($item->jumlah_biaya, 0, ',', '.') }}</td>
                                        <td>{{ $item->santri->nama ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_tagihan)->format('d-F-Y') }}</td>
                                        <td>
                                            <span class="badge 
                                                {{ $item->status == 'lunas' ? 'bg-success' : ($item->status == 'angsuran' ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route($routePrefix . '.show', $item->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> Detail
                                            </a>
                                            <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route($routePrefix . '.destroy', $item->id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            
                        </table>
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection