@extends('template.app_sneat_blank')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-8">
                <div class="p-3 bg-white rounded">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-uppercase">KARTU PEMBAYARAN</h1>
                            <div class="billed"><span class="font-weight-bold text-uppercase"></span><span
                                    class="ml-1">Pesantren Cemerlang Annajach</span></div>
                            <div class="billed"><span class="font-weight-bold text-uppercase"></span>Nama Santri : <span
                                    class="ml-1"> {{ $santri->nama }} </span></div>
                        </div>

                        <div class="mt-3">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>Bulan Tagihan</th>
                                            <th>Item Tagihan</th>
                                            <th>Total</th>
                                            <th>Paraf</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tagihan as $item)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td> {{ \Carbon\Carbon::parse($item->tanggal_tagihan)->translatedFormat('F Y') }}
                                                                                </td>
                                                                                <td>
                                                                                    @foreach($item->tagihanDetails as $detail)
                                                                                        <p>{{ $detail->nama_biaya }}</p>
                                                                                    @endforeach
                                                                                </td>
                                                                                <td>
                                                                                    @php
                                                                                        $jumlah = $item->tagihanDetails->sum('jumlah_biaya');
                                                                                    @endphp
                                                                                    Rp {{ number_format($jumlah, 0, ',', '.') }} </td>
                                                                                <td>{{ $item->jumlah }}</td>
                                                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
</div>@endsection