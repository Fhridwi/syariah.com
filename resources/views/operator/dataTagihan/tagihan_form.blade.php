@extends('template.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $title }}</h5>

                <form action="{{ url($route) }}" method="POST">
                    @csrf
                    @if ($method === 'PUT' || $method === 'PATCH')
                        @method($method)
                    @endif

                    {{-- Pilih Tagihan --}}
                    <div class="mb-3">
                        <label for="jumlah_biaya">Pilih Tagihan</label>
                        <select name="jumlah_biaya" id="jumlah_biaya"
                            class="form-control{{ $errors->has('jumlah_biaya') ? ' is-invalid' : '' }}">
                            <option value="">Pilih Tagihan...</option>
                            @foreach ($biaya as $key => $value)
                                <option value="{{ $key }}" {{ old('jumlah_biaya') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('jumlah_biaya')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Angkatan --}}
                    <div class="mb-3">
                        <label for="angkatan">Tagihan Untuk Angkatan</label>
                        <select name="angkatan" id="angkatan"
                            class="form-control{{ $errors->has('angkatan') ? ' is-invalid' : '' }}">
                            @foreach ($angkatan as $key => $value)
                                <option value="{{ $key }}" {{ old('angkatan') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Tagihan --}}
                    <div class="mb-3">
                        <label for="tanggal_tagihan">Tanggal Tagihan</label>
                        <input type="date" name="tanggal_tagihan" id="tanggal_tagihan"
                            value="{{ old('tanggal_tagihan', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                            class="form-control{{ $errors->has('tanggal_tagihan') ? ' is-invalid' : '' }}">
                        @error('tanggal_tagihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Jatuh Tempo --}}
                    <div class="mb-3">
                        <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo</label>
                        <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                            value="{{ old('tanggal_jatuh_tempo') }}"
                            class="form-control{{ $errors->has('tanggal_jatuh_tempo') ? ' is-invalid' : '' }}">
                        @error('tanggal_jatuh_tempo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-3">
                        <label for="keterangan">Keterangan (opsional)</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
