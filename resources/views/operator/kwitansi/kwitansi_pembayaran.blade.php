@extends('template.app_sneat_blank')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-8">
            <div class="p-3 bg-white rounded">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-uppercase">KWITANSI PEMBAYARAN</h1>
                        <div class="billed"><span class="font-weight-bold text-uppercase"></span><span class="ml-1">Pesantren Cemerlang Annajach</span></div>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Tanggal Tagihan:</span><span class="ml-1">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d F Y') }}
                        </span>
                        </div>
                        <div class="billed"><span class="font-weight-bold ">Pembayaran ID:</span><span class="ml-1">#PEM-{{ $pembayaran->id }}</span></div>
                    </div>
                    
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Jumlah Pembayaran</th>
                                    <th>Metode</th>
                                </tr>
                            </thead>
                            <tbody>
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y') }}</td>
                                                <td>{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                                <td>{{ $pembayaran->metode_pembayaran }}</td>
                                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-right mb-3">
                    Terbilang
                </div>
                <div>
                    Jombang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </div>
                <br>
                <br>
                <br>
                Penerima 
                {{ $pembayaran->user->name }}
            </div>
        </div>
    </div>
</div>@endsection