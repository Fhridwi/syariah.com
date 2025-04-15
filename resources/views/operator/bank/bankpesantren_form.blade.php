@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    <form action="{{ $route }}" method="POST">
                        @csrf
                        @if ($method === 'PUT')
                            @method('PUT')
                        @endif

                        {{-- Pilih Nama Bank --}}
                        <div class="mb-3">
                            <label for="bank_id" class="form-label">Nama Bank</label>
                            <select name="bank_id" id="bank_id" class="form-select {{ $errors->has('bank_id') ? 'is-invalid' : '' }}">
                                <option value="">-- Pilih Bank --</option>
                                @foreach ($listbank as $id => $nama)
                                    <option value="{{ $id }}" {{ old('bank_id', $model->bank_id ?? '') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                            @error('bank_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kode --}}
                        <div class="mb-3">
                            <input type="hidden" name="kode" id="kode" value="{{ old('kode', $model->sandi_bank ?? '') }}" class="form-control {{ $errors->has('kode') ? 'is-invalid' : '' }}" placeholder="Contoh: BSM001">
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nama Rekening --}}
                        <div class="mb-3">
                            <label for="nama_rekening" class="form-label">Nama Rekening</label>
                            <input type="text" name="nama_rekening" id="nama_rekening" value="{{ old('nama_rekening', $model->nama_rekening ?? '') }}" class="form-control {{ $errors->has('nama_rekening') ? 'is-invalid' : '' }}" placeholder="Contoh: Pondok Pesantren">
                            @error('nama_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor Rekening --}}
                        <div class="mb-3">
                            <label for="nomor_rekening" class="form-label">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" id="nomor_rekening" value="{{ old('nomor_rekening', $model->nomor_rekening ?? '') }}" class="form-control {{ $errors->has('nomor_rekening') ? 'is-invalid' : '' }}" placeholder="Contoh: 1234567890">
                            @error('nomor_rekening')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
