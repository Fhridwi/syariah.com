@extends('template.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-primary">{{ $title }}</h5>

                {!! Form::open(['url' => $route, 'method' => $method]) !!}

                {{-- Pilih Tagihan --}}
{{-- Pilih Tagihan --}}
<div class="mb-3">
    {!! Form::label('jumlah_biaya', 'Pilih Tagihan') !!}
    {!! Form::select('jumlah_biaya', $biaya, null, [
        'class' => 'form-control' . ($errors->has('jumlah_biaya') ? ' is-invalid' : ''),
        'placeholder' => 'Pilih Tagihan...'
    ]) !!}
    @error('jumlah_biaya')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


            
               {{-- Angkatan --}}
                <div class="mb-3">
                    {!! Form::label('angkatan', 'Tagihan Untuk Angkatan') !!}
                    {!! Form::select('angkatan', $angkatan, null, ['class' => 'form-control' . ($errors->has('angkatan') ? ' is-invalid' : '')]) !!}
                    @error('angkatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                    {{-- Tanggal Tagihan --}}
                    <div class="mb-3">
                        {!! Form::label('tanggal_tagihan', 'Tanggal Tagihan') !!}
                        {!! Form::date('tanggal_tagihan', old('tanggal_tagihan', \Carbon\Carbon::now()->format('Y-m-d')), [
                            'class' => 'form-control' . ($errors->has('tanggal_tagihan') ? ' is-invalid' : '')
                        ]) !!}
                        @error('tanggal_tagihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

    
                    {{-- Tanggal Jatuh Tempo --}}
                    <div class="mb-3">
                        {!! Form::label('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo') !!}
                        {!! Form::date('tanggal_jatuh_tempo', null, ['class' => 'form-control' . ($errors->has('tanggal_jatuh_tempo') ? ' is-invalid' : '')]) !!}
                        @error('tanggal_jatuh_tempo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                <div class="mb-3">
                    {!! Form::label('keterangan', 'Keterangan (opsional)') !!}
                    {!! Form::textarea('keterangan', null, ['class' => 'form-control', 'rows' => 2]) !!}
                </div>


                {{-- Tombol Submit --}}
                <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
