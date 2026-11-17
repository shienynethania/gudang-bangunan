@extends('layout')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Data Penjualan</h4>
  <form action="{{ route('penjualan.store') }}" method="POST" class="d-flex gap-2">
    @csrf
    <select name="iduser" class="form-select" required>
      @foreach($user as $u)
        <option value="{{ $u->iduser }}">{{ $u->username }}</option>
      @endforeach
    </select>
    <button class="btn btn-primary text-nowrap">+ Penjualan Baru</button>
  </form>
</div>
<p class="text-muted">Margin aktif: <b>{{ $margin ? $margin->persen . '%' : 'belum ada' }}</b></p>

<table class="table table-bordered bg-white">
  <tr><th>ID</th><th>Tanggal</th><th>Kasir</th><th>Margin</th><th>Total</th><th width="100">Aksi</th></tr>
  @forelse($data as $d)
  <tr>
    <td>{{ $d->idpenjualan }}</td>
    <td>{{ $d->tanggal }}</td>
    <td>{{ $d->username }}</td>
    <td>{{ $d->margin_persen }}%</td>
    <td>Rp {{ number_format($d->total_nilai, 0, ',', '.') }}</td>
    <td><a href="{{ route('penjualan.show', $d->idpenjualan) }}" class="btn btn-sm btn-info">Detail</a></td>
  </tr>
  @empty
  <tr><td colspan="6" class="text-center text-muted">Belum ada penjualan</td></tr>
  @endforelse
</table>
@endsection
