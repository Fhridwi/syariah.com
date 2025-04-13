@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    {{-- Form --}}
                    <form action="{{ $route }}" method="POST">
                        @csrf
                        @method($method)

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama" value="{{ old('name', $model->name ?? '') }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email', $model->email ?? '') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Nomor HP --}}
                        <div class="mb-3">
                            <label for="nohp">Nomor HP</label>
                            <input type="text" name="nohp" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('nohp', $model->nohp ?? '') }}">
                            @error('nohp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Hak Akses --}}
                        <div class="mb-3">
                            <label for="akses">Hak Akses</label>
                            <select name="akses" class="form-control">
                                <option value="" disabled selected>Pilih hak akses</option>
                                <option value="admin" {{ old('akses', $model->akses ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="operator" {{ old('akses', $model->akses ?? '') == 'operator' ? 'selected' : '' }}>Operator</option>
                                <option value="wali" {{ old('akses', $model->akses ?? '') == 'wali' ? 'selected' : '' }}>Wali</option>
                            </select>
                            @error('akses')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
