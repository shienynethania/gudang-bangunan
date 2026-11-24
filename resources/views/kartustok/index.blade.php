@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Kartu Stok</h4>
  <form method="GET" action="{{ route('kartustok.index') }}" class="d-flex gap-2">
    <select name="idbarang" class="form-select">
      <option value="">-- semua barang --</option>
      @foreach($barang as $b)
        <option value="{{ $b->idbarang }}" @selected($idbarang == $b->idbarang)>{{ $b->nama }}</option>
      @endforeach
    </select>
    <button class="btn btn-primary">Tampilkan</button>
  </form>
</div>

<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th>
    <th>Tanggal</th>
    <th>Barang</th>
    <th>Transaksi</th>
    <th>No. Transaksi</th>
    <th>Masuk</th>
    <th>Keluar</th>
    <th>Stok</th>
  </tr>
  @forelse($data as $d)
  <tr>
    <td>{{ $d->idkartu_stok }}</td>
    <td>{{ $d->tanggal }}</td>
    <td>{{ $d->nama }}</td>
    <td>{{ $d->nama_transaksi }}</td>
    <td>
      @if($d->jenis_transaksi == 'P')
        <a href="{{ route('penerimaan.show', $d->idtransaksi) }}">#{{ $d->idtransaksi }}</a>
      @elseif($d->jenis_transaksi == 'J')
        <a href="{{ route('penjualan.show', $d->idtransaksi) }}">#{{ $d->idtransaksi }}</a>
      @else
        #{{ $d->idtransaksi }}
      @endif
    </td>
    <td>{{ $d->masuk }}</td>
    <td>{{ $d->keluar }}</td>
    <td><b>{{ $d->stok }}</b></td>
  </tr>
  @empty
  <tr><td colspan="8" class="text-center text-muted">Belum ada riwayat stok</td></tr>
  @endforelse
</table>
@endsection
