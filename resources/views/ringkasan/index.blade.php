@extends('layout')

@section('content')
{{-- KARTU RINGKAS --}}
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card border-danger"><div class="card-body">
      <div class="text-muted">Barang Habis</div>
      <h3 class="text-danger mb-0">{{ $jmlHabis }}</h3>
    </div></div>
  </div>
  <div class="col-md-3">
    <div class="card border-warning"><div class="card-body">
      <div class="text-muted">Stok Menipis (&le; 10)</div>
      <h3 class="text-warning mb-0">{{ $jmlMenipis }}</h3>
    </div></div>
  </div>
  <div class="col-md-3">
    <div class="card border-primary"><div class="card-body">
      <div class="text-muted">Pengadaan Pending</div>
      <h3 class="text-primary mb-0">{{ $jmlPengadaanPending }}</h3>
    </div></div>
  </div>
  <div class="col-md-3">
    <div class="card border-success"><div class="card-body">
      <div class="text-muted">Penjualan Hari Ini</div>
      <h3 class="text-success mb-0">Rp {{ number_format($hariIni->nilai_penjualan ?? 0, 0, ',', '.') }}</h3>
    </div></div>
  </div>
</div>

{{-- 1. PANTAU STOK --}}
<h4 class="mb-3">Pantau Stok Barang</h4>
<table class="table table-bordered bg-white mb-5">
  <tr>
    <th>ID</th><th>Barang</th><th>Stok Aktual</th><th>Akan Masuk</th><th>Harga Jual</th><th>Keterangan</th>
  </tr>
  @foreach($stok as $d)
  <tr>
    <td>{{ $d->idbarang }}</td>
    <td>{{ $d->nama }}</td>
    <td><b>{{ $d->stok }}</b> {{ $d->nama_satuan }}</td>
    <td>
      @if($d->sisa_pesanan > 0)
        <span class="text-primary">+{{ $d->sisa_pesanan }} {{ $d->nama_satuan }}</span>
      @else
        <span class="text-muted">-</span>
      @endif
    </td>
    <td>Rp {{ number_format($d->harga_jual, 0, ',', '.') }}</td>
    <td>
      <span class="badge {{ $d->status_stok == 'HABIS' ? 'bg-danger' : ($d->status_stok == 'MENIPIS' ? 'bg-warning text-dark' : 'bg-success') }}">
        {{ $d->keterangan }}
      </span>
    </td>
  </tr>
  @endforeach
</table>

{{-- 2. PESANAN PENGADAAN --}}
<h4 class="mb-3">Pesanan Pengadaan yang Belum Diterima</h4>
<table class="table table-bordered bg-white mb-5">
  <tr>
    <th>Pengadaan</th><th>Tanggal</th><th>Vendor</th><th>Barang</th><th>Dipesan</th><th>Diterima</th><th>Sisa</th>
  </tr>
  @forelse($pesanan as $d)
  <tr>
    <td><a href="{{ route('pengadaan.show', $d->idpengadaan) }}">#{{ $d->idpengadaan }}</a></td>
    <td>{{ $d->tanggal }}</td>
    <td>{{ $d->nama_vendor }}</td>
    <td>{{ $d->nama_barang }} ({{ $d->nama_satuan }})</td>
    <td>{{ $d->dipesan }}</td>
    <td>{{ $d->diterima }}</td>
    <td><b>{{ $d->sisa }}</b></td>
  </tr>
  @empty
  <tr><td colspan="7" class="text-center text-muted">Tidak ada pesanan yang menunggu</td></tr>
  @endforelse
</table>

{{-- 3. TRANSAKSI HARIAN --}}
<h4 class="mb-3">Transaksi Harian (7 hari terakhir)</h4>
<table class="table table-bordered bg-white">
  <tr>
    <th>Tanggal</th>
    <th>Pengadaan</th><th>Nilai Pengadaan</th>
    <th>Penerimaan</th>
    <th>Penjualan</th><th>Nilai Penjualan</th>
  </tr>
  @forelse($harian as $d)
  <tr>
    <td>{{ $d->tanggal }}</td>
    <td>{{ $d->jml_pengadaan }}</td>
    <td>Rp {{ number_format($d->nilai_pengadaan, 0, ',', '.') }}</td>
    <td>{{ $d->jml_penerimaan }}</td>
    <td>{{ $d->jml_penjualan }}</td>
    <td>Rp {{ number_format($d->nilai_penjualan, 0, ',', '.') }}</td>
  </tr>
  @empty
  <tr><td colspan="6" class="text-center text-muted">Belum ada transaksi</td></tr>
  @endforelse
</table>
@endsection
