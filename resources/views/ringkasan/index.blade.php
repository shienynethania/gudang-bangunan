@extends('layout')

@section('content')
<h4 class="mb-3">Ringkasan Barang per Satuan</h4>
<table class="table table-bordered bg-white mb-5">
  <tr>
    <th>Satuan</th>
    <th>Jumlah Barang</th>
    <th>Harga Min</th>
    <th>Harga Max</th>
    <th>Harga Rata-rata</th>
  </tr>
  @foreach($perSatuan as $d)
  <tr>
    <td>{{ $d->nama_satuan }}</td>
    <td>{{ $d->jumlah_barang }}</td>
    <td>{{ $d->harga_min ? 'Rp '.number_format($d->harga_min, 0, ',', '.') : '-' }}</td>
    <td>{{ $d->harga_max ? 'Rp '.number_format($d->harga_max, 0, ',', '.') : '-' }}</td>
    <td>{{ $d->harga_rata ? 'Rp '.number_format($d->harga_rata, 0, ',', '.') : '-' }}</td>
  </tr>
  @endforeach
</table>

<h4 class="mb-3">Barang dengan Harga di Atas Rata-rata</h4>
<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th>
    <th>Nama Barang</th>
    <th>Harga</th>
  </tr>
  @foreach($diAtasRata as $d)
  <tr>
    <td>{{ $d->idbarang }}</td>
    <td>{{ $d->nama }}</td>
    <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
  </tr>
  @endforeach
</table>
@endsection
