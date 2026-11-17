@extends('layout')
@section('content')
<h4>Pengadaan #{{ $p->idpengadaan }} - Langkah 2: Detail Barang</h4>
<p>
  Vendor: <b>{{ $p->nama_vendor }}</b> | User: {{ $p->username }} | Tanggal: {{ $p->tanggal }} |
  Status: <span class="badge {{ $p->status == 'T' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $p->status_text }}</span>
</p>

@if($p->status == 'P')
<form action="{{ route('pengadaan.detail', $p->idpengadaan) }}" method="POST" class="row g-2 mb-3">
  @csrf
  <div class="col-md-6">
    <select name="idbarang" class="form-select" required>
      <option value="">-- pilih barang --</option>
      @foreach($barang as $b)
        <option value="{{ $b->idbarang }}">{{ $b->nama }} ({{ $b->nama_satuan }}) - Rp {{ number_format($b->harga, 0, ',', '.') }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3"><input type="number" name="jumlah" min="1" class="form-control" placeholder="Jumlah" required></div>
  <div class="col-md-3"><button class="btn btn-primary w-100">Tambah Barang</button></div>
</form>
@endif

<table class="table table-bordered bg-white">
  <tr><th>Barang</th><th>Satuan</th><th>Harga</th><th>Jumlah</th><th>Sub Total</th></tr>
  @forelse($detail as $d)
  <tr>
    <td>{{ $d->nama }}</td>
    <td>{{ $d->nama_satuan }}</td>
    <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
    <td>{{ $d->jumlah }}</td>
    <td>Rp {{ number_format($d->sub_total, 0, ',', '.') }}</td>
  </tr>
  @empty
  <tr><td colspan="5" class="text-center text-muted">Belum ada barang</td></tr>
  @endforelse
  <tr><th colspan="4" class="text-end">Subtotal</th><th>Rp {{ number_format($p->subtotal_nilai, 0, ',', '.') }}</th></tr>
  <tr><th colspan="4" class="text-end">PPN 10%</th><th>Rp {{ number_format($p->ppn, 0, ',', '.') }}</th></tr>
  <tr><th colspan="4" class="text-end">Total</th><th>Rp {{ number_format($p->total_nilai, 0, ',', '.') }}</th></tr>
</table>
<a href="{{ route('pengadaan.index') }}" class="btn btn-secondary">Selesai</a>
@endsection
