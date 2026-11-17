@extends('layout')
@section('content')
<h4>Penjualan #{{ $p->idpenjualan }}</h4>
<p>Kasir: <b>{{ $p->username }}</b> | Margin: <b>{{ $p->margin_persen }}%</b> | Tanggal: {{ $p->tanggal }}</p>

<form action="{{ route('penjualan.detail', $p->idpenjualan) }}" method="POST" class="row g-2 mb-3">
  @csrf
  <div class="col-md-6">
    <select name="idbarang" class="form-select" required>
      <option value="">-- pilih barang --</option>
      @foreach($barang as $b)
        <option value="{{ $b->idbarang }}">{{ $b->nama }} ({{ $b->nama_satuan }}) - stok {{ $b->stok }} - Rp {{ number_format($b->harga_jual, 0, ',', '.') }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3"><input type="number" name="jumlah" min="1" class="form-control" placeholder="Jumlah" required></div>
  <div class="col-md-3"><button class="btn btn-primary w-100">Tambah Barang</button></div>
</form>

<table class="table table-bordered bg-white">
  <tr><th>Barang</th><th>Satuan</th><th>Harga</th><th>Jumlah</th><th>Sub Total</th></tr>
  @forelse($detail as $d)
  <tr>
    <td>{{ $d->nama }}</td>
    <td>{{ $d->nama_satuan }}</td>
    <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
    <td>{{ $d->jumlah }}</td>
    <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
  </tr>
  @empty
  <tr><td colspan="5" class="text-center text-muted">Belum ada barang</td></tr>
  @endforelse
  <tr><th colspan="4" class="text-end">Subtotal</th><th>Rp {{ number_format($p->subtotal_nilai, 0, ',', '.') }}</th></tr>
  <tr><th colspan="4" class="text-end">PPN 10%</th><th>Rp {{ number_format($p->ppn, 0, ',', '.') }}</th></tr>
  <tr><th colspan="4" class="text-end">Total</th><th>Rp {{ number_format($p->total_nilai, 0, ',', '.') }}</th></tr>
</table>
<a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Selesai</a>
@endsection
