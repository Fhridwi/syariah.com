@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    <form action="{{ route($route) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if ($method === 'PUT' || $method === 'PATCH')
                            @method($method)
                        @endif

                        {{-- Wali Santri --}}
                        <div class="mb-3">
                            <label for="wali_id" class="form-label">Wali Santri</label>
                            <select name="wali_id" id="wali_id"
                                class="form-control select2{{ $errors->has('wali_id') ? ' is-invalid' : '' }}"
                                required>
                                <option value="">Pilih Wali Santri</option>
                                @foreach ($users as $id => $name)
                                    <option value="{{ $id }}" {{ old('wali_id', $model->wali_id ?? '') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wali_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Santri</label>
                            <input type="text" name="nama" id="nama"
                                class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}"
                                value="{{ old('nama', $model->nama ?? '') }}"
                                placeholder="Masukkan nama santri">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIS --}}
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" name="nis" id="nis"
                                class="form-control{{ $errors->has('nis') ? ' is-invalid' : '' }}"
                                value="{{ old('nis', $model->nis ?? '') }}"
                                placeholder="Masukkan NIS">
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Program --}}
                        <div class="mb-3">
                            <label for="program" class="form-label">Program</label>
                            <input type="text" name="program" id="program"
                                class="form-control{{ $errors->has('program') ? ' is-invalid' : '' }}"
                                value="{{ old('program', $model->program ?? '') }}"
                                placeholder="Contoh: RPL, Multimedia">
                            @error('program')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Angkatan --}}
                        <div class="mb-3">
                            <label for="angkatan" class="form-label">Angkatan</label>
                            <select name="angkatan" id="angkatan"
                                class="form-control{{ $errors->has('angkatan') ? ' is-invalid' : '' }}">
                                <option value="">Pilih angkatan</option>
                                @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                                    <option value="{{ $year }}" {{ old('angkatan', $model->angkatan ?? '') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            @error('angkatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Foto --}}
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <small class="text-muted d-block mb-1">*Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                            <input type="file" name="foto" id="foto"
                                class="form-control{{ $errors->has('foto') ? ' is-invalid' : '' }}">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if (!empty($model->foto))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $model->foto) }}" alt="Foto Santri" width="100">
                                </div>
                            @endif
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
