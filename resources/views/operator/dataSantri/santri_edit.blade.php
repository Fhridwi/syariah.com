@extends('template.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $title }}</h5>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route($route) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method($method)

                    {{-- Nama Santri --}}
                    <div class="mb-3">
                        <label for="nama">Nama Santri</label>
                        <input type="text" name="nama" id="nama" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" placeholder="Masukkan nama santri" value="{{ old('nama', $model->nama) }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NIS --}}
                    <div class="mb-3">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control{{ $errors->has('nis') ? ' is-invalid' : '' }}" placeholder="Masukkan NIS" value="{{ old('nis', $model->nis) }}">
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Program --}}
                    <div class="mb-3">
                        <label for="program">Program</label>
                        <input type="text" name="program" id="program" class="form-control{{ $errors->has('program') ? ' is-invalid' : '' }}" placeholder="Contoh: RPL, Multimedia" value="{{ old('program', $model->program) }}">
                        @error('program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Angkatan --}}
                    <div class="mb-3">
                        <label for="angkatan">Angkatan</label>
                        <select name="angkatan" id="angkatan" class="form-control{{ $errors->has('angkatan') ? ' is-invalid' : '' }}">
                            <option value="">Pilih angkatan</option>
                            @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                                <option value="{{ $year }}" {{ old('angkatan', $model->angkatan) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Akun Wali --}}
                    <div class="mb-3">
                        <label for="user_id">Akun Wali</label>
                        <select name="user_id" id="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}">
                            <option value="">Pilih wali santri</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}" {{ old('user_id', $model->user_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3">
                        <label for="foto">Foto Santri</label>

                        @if ($model->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $model->foto) }}" alt="Foto Santri" width="120" class="img-thumbnail">
                            </div>
                        @endif

                        <input type="file" name="foto" id="foto" class="form-control{{ $errors->has('foto') ? ' is-invalid' : '' }}">
                        @error('foto')
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
