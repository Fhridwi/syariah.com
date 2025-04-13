@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    {{-- Tampilkan pesan error jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ $route }}" method="{{ $method }}">
                        {{-- Nama Wali Santri --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Wali Santri</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama wali santri" value="{{ old('name', $model->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" value="{{ old('email', $model->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor HP --}}
                        <div class="mb-3">
                            <label for="nohp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="nohp" name="nohp" placeholder="08xxxxxxxxxx" value="{{ old('nohp', $model->nohp) }}">
                            @error('nohp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Hak Akses --}}
                        @if (Route::is('user.create'))
                            <div class="mb-3">
                                <label for="akses" class="form-label">Hak Akses</label>
                                <select class="form-control" id="akses" name="akses">
                                    <option value="admin" {{ old('akses', $model->akses) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="operator" {{ old('akses', $model->akses) == 'operator' ? 'selected' : '' }}>Operator</option>
                                    <option value="wali" {{ old('akses', $model->akses) == 'wali' ? 'selected' : '' }}>Wali</option>
                                </select>
                            </div>
                        @endif

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
