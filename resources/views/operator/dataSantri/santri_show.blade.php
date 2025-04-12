@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Detail Santri</h5>

                    <div class="row">
                        <div class="col-md-3">
                            @if ($model->foto)
                            <img src="{{ asset('storage/'.$model->foto) }}" alt="Foto Santri" class="img-fluid rounded mb-3">
                            @else
                                <img src="{{ asset('images/default.png') }}" alt="Default Foto" class="img-fluid rounded mb-3">
                            @endif
                        </div>

                        <div class="col-md-9">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $model->nama }}</td>
                                </tr>
                                <tr>
                                    <th>NIS</th>
                                    <td>{{ $model->nis }}</td>
                                </tr>
                                <tr>
                                    <th>Program</th>
                                    <td>{{ $model->program }}</td>
                                </tr>
                                <tr>
                                    <th>Angkatan</th>
                                    <td>{{ $model->angkatan }}</td>
                                </tr>
                                <tr>
                                    <th>Akun Wali</th>
                                    <td>{{ $model->user->name ?? '-' }} ({{ $model->user->email ?? '-' }})</td>
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
                        </div>
                    </div>

                    <a href="{{ route('santri.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
