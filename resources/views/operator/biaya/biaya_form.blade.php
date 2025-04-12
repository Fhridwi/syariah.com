@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    {!! Form::open(['route' => $route, 'method' => $method]) !!}

                    {{-- Nama Biaya --}}
                    <div class="mb-3">
                        {!! Form::label('nama', 'Nama Biaya') !!}
                        {!! Form::text('nama', null, ['class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : ''), 'placeholder' => 'Contoh: Infaq, Uang Gedung']) !!}
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jumlah --}}
                    <div class="mb-3">
                        {!! Form::label('jumlah', 'Jumlah Biaya') !!}
                        {!! Form::number('jumlah', null, ['step' => '0.01', 'class' => 'form-control ' . ($errors->has('jumlah') ? ' is-invalid' : ''), 'placeholder' => 'Contoh: 1500000']) !!}
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Submit --}}
                    <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
