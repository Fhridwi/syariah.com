@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">DATA SANTRI</h5>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus"></i> Tambah Data
                        </a>
                    </div>


                    <div class="table-responsive table-responsive-sm table-responsive-md">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Wali Santri</th>
                                    <th>Nama</th>
                                    <th>NIS</th>
                                    <th>Program</th>
                                    <th>Angkatan</th>
                                    <th>Status Wali</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->wali?->name ?? '-' }}<x/td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nis }}</td>
                                        <td>{{ $item->program }}</td>
                                        <td>{{ $item->angkatan }}</td>
                                        <td>{{ $item->wali_status ?? '-' }}</td>
                                     
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