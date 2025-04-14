@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>
                    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm btn-primary">Tambah Data</a>
             <div class="table-responsive" style="overflow-x: auto;">
    <table class="table table-striped" style="min-width: 800px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>Akses</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->nohp }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->akses }}</td>
                                        <td>
                                            {{-- Edit --}}
                                            <a href="{{ route($routePrefix . '.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        
                                            {{--  Delete --}}
                                            <form action="{{ route($routePrefix .'.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                        <td colspan="5" class="text-center">Data tidak ditemukan.</td>
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
