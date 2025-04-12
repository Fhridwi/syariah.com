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
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                   

                    {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}

                        {{-- Nama --}}
                        <div class="mb-3">
                            {!! Form::label('name', 'Nama') !!}
                            {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Masukkan nama']) !!}
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Masukkan email']) !!}
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nomor HP --}}
                        <div class="mb-3">
                            {!! Form::label('nohp', 'Nomor HP') !!}
                            {!! Form::text('nohp', null, ['class' => 'form-control' . ($errors->has('nohp') ? ' is-invalid' : ''), 'placeholder' => '08xxxxxxxxxx']) !!}
                            @error('nohp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                      @if (Route::is('user.create'))
                            {{-- Hak Akses --}}
                        <div class="mb-3">
                            {!! Form::label('akses', 'Hak Akses') !!}
                            {!! Form::select('akses', ['admin' => 'Admin', 'operator' => 'Operator', 'wali' => 'Wali'], null, ['class' => 'form-control' . ($errors->has('akses') ? ' is-invalid' : ''), 'placeholder' => 'Pilih hak akses']) !!}
                        </div>
                      @endif

                        {{-- Password --}}
                        <div class="mb-3">
                            {!! Form::label('password', 'Password') !!}
                            {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Masukkan password']) !!}
                            @error('password')
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
