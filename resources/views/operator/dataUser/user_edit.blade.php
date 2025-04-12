@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    {{-- Form --}}
                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}

                        {{-- Nama --}}
                        <div class="mb-3">
                            {!! Form::label('name', 'Nama') !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Masukkan nama']) !!}
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Masukkan email']) !!}
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Nomor HP --}}
                        <div class="mb-3">
                            {!! Form::label('nohp', 'Nomor HP') !!}
                            {!! Form::text('nohp', null, ['class' => 'form-control', 'placeholder' => '08xxxxxxxxxx']) !!}
                            @error('nohp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Hak Akses --}}
                        <div class="mb-3">
                            {!! Form::label('akses', 'Hak Akses') !!}
                            {!! Form::select('akses', ['admin' => 'Admin', 'operator' => 'Operator', 'wali' => 'Wali'], null, ['class' => 'form-control', 'placeholder' => 'Pilih hak akses']) !!}
                            @error('akses')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            {!! Form::label('password', 'Password') !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Masukkan password']) !!}
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
