@extends('layout')
@section('content')
<div class="d-flex justify-content-between mb-3">
  <h4>Data Penerimaan</h4>
  <a href="{{ route('penerimaan.create') }}" class="btn btn-primary">+ Penerimaan Baru</a>
</div>

<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th><th>Tanggal</th><th>Pengadaan</th><th>Vendor</th><th>User</th><th>Status</th><th width="100">Aksi</th>
  </tr>
  @forelse($data as $d)
  <tr>
    <td>{{ $d->idpenerimaan }}</td>
    <td>{{ $d->tanggal }}</td>
    <td>#{{ $d->idpengadaan }}</td>
    <td>{{ $d->nama_vendor }}</td>
    <td>{{ $d->username }}</td>
    <td><span class="badge {{ $d->status == 'T' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $d->status_text }}</span></td>
    <td><a href="{{ route('penerimaan.show', $d->idpenerimaan) }}" class="btn btn-sm btn-info">Detail</a></td>
  </tr>
  @empty
  <tr><td colspan="7" class="text-center text-muted">Belum ada penerimaan</td></tr>
  @endforelse
</table>
@endsection
