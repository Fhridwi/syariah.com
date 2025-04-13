@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $model->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $model->email }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor HP</th>
                                    <td>{{ $model->nohp }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat pada</th>
                                    <td>{{ $model->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Diperbarui pada</th>
                                    <td>{{ $model->updated_at->format('d M Y, H:i') }}</td>
                                </tr>
                            </table>

                            <h5 class="mt-4">Tambah Anak (Santri)</h5>
                            <form action="{{ route('walisantri.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="wali_id" value="{{ $model->id }}">
                                <div class="input-group mb-3">
                                    <select name="santri_id" class="form-control select2">
                                        <option value="" disabled selected>Pilih Santri</option>
                                        @foreach($santri as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-sm mx-2 btn-primary">Tambah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <h5 class="mt-4">Data Anak (Santri)</h5>
                    <table class="table table-striped mt-2">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Program</th>
                                <th>Sekolah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($model->santri as $santri)
                                <tr>
                                    <td>{{ $santri->nama }}</td>
                                    <td>{{ $santri->program }}</td>
                                    <td>{{ $santri->sekolah }}</td>
                                    <td class="d-flex mx-2">
                                        <form action="{{ route('walisantri.update', $santri->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus santri ini?')">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data santri.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <a href="{{ route('wali.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
