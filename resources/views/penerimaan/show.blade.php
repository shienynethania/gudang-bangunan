@extends('layout')
@section('content')
<h4>Penerimaan #{{ $pn->idpenerimaan }} - Langkah 2: Detail Penerimaan</h4>
<p>
  Pengadaan: <b>#{{ $pn->idpengadaan }}</b> | Vendor: <b>{{ $pn->nama_vendor }}</b> | User: {{ $pn->username }} |
  Status: <span class="badge {{ $pengadaan->status == 'T' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $pengadaan->status_text }}</span>
</p>

<h6>Pesanan vs Diterima (selisih = sisa)</h6>
<form action="{{ route('penerimaan.detail', $pn->idpenerimaan) }}" method="POST">
  @csrf
  <table class="table table-bordered bg-white">
    <tr>
      <th>Barang</th><th>Satuan</th><th>Dipesan</th><th>Sudah Diterima</th><th>Sisa</th><th width="170">Terima Sekarang</th>
    </tr>
    @foreach($sisa as $s)
    <tr class="{{ $s->sisa == 0 ? 'table-success' : '' }}">
      <td>{{ $s->nama }}</td>
      <td>{{ $s->nama_satuan }}</td>
      <td>{{ $s->dipesan }}</td>
      <td>{{ $s->diterima }}</td>
      <td>{{ $s->sisa }}</td>
      <td>
        @if($s->sisa > 0 && $pengadaan->status == 'P')
          <input type="number" name="jumlah[{{ $s->idbarang }}]" min="0" max="{{ $s->sisa }}" value="0" class="form-control form-control-sm">
        @else
          <span class="text-muted">-</span>
        @endif
      </td>
    </tr>
    @endforeach
  </table>
  @if($pengadaan->status == 'P')
    <button class="btn btn-primary">Simpan Penerimaan</button>
  @endif
  <a href="{{ route('penerimaan.index') }}" class="btn btn-secondary">Selesai</a>
</form>

<h6 class="mt-4">Barang diterima pada penerimaan ini</h6>
<table class="table table-bordered bg-white">
  <tr><th>Barang</th><th>Satuan</th><th>Jumlah</th><th>Harga</th><th>Sub Total</th></tr>
  @forelse($detail as $d)
  <tr>
    <td>{{ $d->nama }}</td>
    <td>{{ $d->nama_satuan }}</td>
    <td>{{ $d->jumlah_terima }}</td>
    <td>Rp {{ number_format($d->harga_satuan_terima, 0, ',', '.') }}</td>
    <td>Rp {{ number_format($d->sub_total_terima, 0, ',', '.') }}</td>
  </tr>
  @empty
  <tr><td colspan="5" class="text-center text-muted">Belum ada barang diterima</td></tr>
  @endforelse
</table>
@endsection
