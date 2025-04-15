@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    <div class=" align-items-center mb-3">
                        <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm btn-primary">
                            <i class="bx bx-plus"></i> Tambah Data
                        </a>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bank</th>
                                    <th>Kode Transfer</th>
                                    <th>Pemilik Rekening</th>
                                    <th>Nomor Rekening</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_bank}}<x/td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama_rekening }}</td>
                                        <td>{{ $item->nomor_rekening }}</td>
                                        <td>
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
                                        <td colspan="8" class="text-center">Data tidak ditemukan.</td>
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