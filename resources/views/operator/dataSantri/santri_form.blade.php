@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">{{ $title }}</h5>

                    {!! Form::open(['route' => $route, 'method' => $method, 'enctype' => 'multipart/form-data']) !!}

                    {{-- Wali Santri --}}
                    <div class="mb-3">
                        {!! Form::label('wali_id', 'Wali Santri') !!}
                        {!! Form::select('wali_id', $users, null, ['class' => 'form-control select2' . ($errors->has('wali_id') ? ' is-invalid' : ''), 'placeholder' => 'Pilih Wali Santri', 'required' => false]) !!}
                        @error('wali_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama --}}
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

                    {{-- Foto --}}
                    <div class="mb-3">
                        {!! Form::label('foto', 'Foto') !!}
                        <small class="text-muted d-block mb-1">*Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                        {!! Form::file('foto', ['class' => 'form-control' . ($errors->has('foto') ? ' is-invalid' : '')]) !!}
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($model->foto)
                            <div class="mt-2">
                            </div>
                        @endif
                    </div>



                    {{-- Tombol Submit --}}
                    <button type="submit" class="btn btn-primary btn-sm">{{ $button ?? 'Simpan' }}</button>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection