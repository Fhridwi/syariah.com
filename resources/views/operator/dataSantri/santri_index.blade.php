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

                        <form action="{{ route($routePrefix . '.index') }}" method="GET" class="d-flex">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="basic-addon-search31">
                                    <i class="bx bx-search"></i>
                                </span>
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Cari data..."
                                    aria-label="Search..."
                                    aria-describedby="basic-addon-search31"
                                >
                                <button type="submit" class="btn btn-sm btn-secondary">
                                    <i class="bx bx-search"></i> Cari
                                </button>
                            </div>
                        </form>
                        


                    <div class="table-responsive">
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
                                    <th>Aksi</th>
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
                                        <td>
                                            <a href="{{ route($routePrefix . '.show', $item->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i> Detail
                                            </a>

                                            <a href="{{ route($routePrefix . '.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">
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