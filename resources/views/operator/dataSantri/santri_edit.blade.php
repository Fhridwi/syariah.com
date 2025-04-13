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

                {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true]) !!}

                    {{-- Nama Santri --}}
                    <div class="mb-3">
                        {!! Form::label('nama', 'Nama Santri') !!}
                        {!! Form::text('nama', null, ['class' => 'form-control' . ($errors->has('nama') ? ' is-invalid' : ''), 'placeholder' => 'Masukkan nama santri']) !!}
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NIS --}}
                    <div class="mb-3">
                        {!! Form::label('nis', 'NIS') !!}
                        {!! Form::text('nis', null, ['class' => 'form-control' . ($errors->has('nis') ? ' is-invalid' : ''), 'placeholder' => 'Masukkan NIS']) !!}
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Program --}}
                    <div class="mb-3">
                        {!! Form::label('program', 'Program') !!}
                        {!! Form::text('program', null, ['class' => 'form-control' . ($errors->has('program') ? ' is-invalid' : ''), 'placeholder' => 'Contoh: RPL, Multimedia']) !!}
                        @error('program')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                  
                    {{-- Angkatan --}}
                    <div class="mb-3">
                        {!! Form::label('angkatan', 'Angkatan') !!}
                        {!! Form::selectRange('angkatan', date('Y'), date('Y') - 5, null, [
                        'class' => 'form-control' . ($errors->has('angkatan') ? ' is-invalid' : ''),
                        'placeholder' => 'Pilih angkatan'
                    ]) !!}
                        @error('angkatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Akun Wali --}}
                    <div class="mb-3">
                        {!! Form::label('user_id', 'Akun Wali') !!}
                        {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'placeholder' => 'Pilih wali santri']) !!}
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="mb-3">
                        {!! Form::label('foto', 'Foto Santri') !!}
                        
                        {{-- Preview Foto jika ada --}}
                        @if ($model->foto)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $model->foto) }}" alt="Foto Santri" width="120" class="img-thumbnail">
                            </div>
                        @endif

                        {!! Form::file('foto', ['class' => 'form-control' . ($errors->has('foto') ? ' is-invalid' : '')]) !!}
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Simpan --}}
                    <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
