@extends('layout')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data Pengadaan</h4>
  <a href="{{ route('pengadaan.create') }}" class="btn btn-primary">+ Pengadaan Baru</a>
</div>

<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th><th>Tanggal</th><th>Vendor</th><th>User</th><th>Status</th><th>Total</th><th width="100">Aksi</th>
  </tr>
  @forelse($data as $d)
  <tr>
    <td>{{ $d->idpengadaan }}</td>
    <td>{{ $d->tanggal }}</td>
    <td>{{ $d->nama_vendor }}</td>
    <td>{{ $d->username }}</td>
    <td><span class="badge {{ $d->status == 'T' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $d->status_text }}</span></td>
    <td>Rp {{ number_format($d->total_nilai, 0, ',', '.') }}</td>
    <td><a href="{{ route('pengadaan.show', $d->idpengadaan) }}" class="btn btn-sm btn-info">Detail</a></td>
  </tr>
  @empty
  <tr><td colspan="7" class="text-center text-muted">Belum ada pengadaan</td></tr>
  @endforelse
</table>
@endsection
