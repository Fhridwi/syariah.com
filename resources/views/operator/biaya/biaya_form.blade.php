@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    <form action="{{ route($route) }}" method="{{ strtolower($method) === 'get' ? 'GET' : 'POST' }}">
                        @csrf
                        @if(strtoupper($method) !== 'GET' && strtoupper($method) !== 'POST')
                            @method($method)
                        @endif

                        {{-- Nama Biaya --}}
                        <div class="mb-3">
                            <label for="nama">Nama Biaya</label>
                            <input
                                type="text"
                                name="nama"
                                id="nama"
                                value="{{ old('nama') }}"
                                class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}"
                                placeholder="Contoh: Infaq, Uang Gedung"
                            >
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-3">
                            <label for="jumlah">Jumlah Biaya</label>
                            <input
                                type="number"
                                name="jumlah"
                                id="jumlah"
                                value="{{ old('jumlah') }}"
                                step="0.01"
                                class="form-control{{ $errors->has('jumlah') ? ' is-invalid' : '' }}"
                                placeholder="Contoh: 1500000"
                            >
                            @error('jumlah')
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
