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
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon-search31">
                                <i class="bx bx-search"></i>
                            </span>
                            {!! Form::text('search', request('search'), [
                                'class' => 'form-control',
                                'placeholder' => 'Cari data...',
                                'aria-label' => 'Search...',
                                'aria-describedby' => 'basic-addon-search31'
                            ]) !!}
                            <button type="submit" class="btn btn-sm btn-secondary">
                                <i class="bx bx-search"></i> Cari
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>


                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Biaya</th>
                                    <th>Jumlah</th>
                                    <th>create by</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama}}<x/td>
                                            <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                            <td>{{ $item->user_id }}</td>
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