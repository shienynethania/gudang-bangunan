@extends('layout')

@section('content')
@php $kelola = in_array((int) session('idrole'), [1,3]); @endphp
<div class="d-flex justify-content-between mb-3">
  <h4>Data Vendor</h4>
  @if($kelola)
    <a href="{{ route('vendor.create') }}" class="btn btn-primary">+ Tambah</a>
  @endif
</div>

<table class="table table-bordered bg-white">
  <tr>
    <th>ID</th>
    <th>Nama Vendor</th>
    <th>Badan Hukum</th>
    <th>Status</th>
    @if($kelola) <th width="150">Aksi</th> @endif
  </tr>
  @foreach($data as $d)
  <tr>
    <td>{{ $d->idvendor }}</td>
    <td>{{ $d->nama_vendor }}</td>
    <td>{{ $d->badan_hukum_text }}</td>
    <td>{{ $d->status_text }}</td>
    @if($kelola)
    <td>
      <a href="{{ route('vendor.edit', $d->idvendor) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('vendor.destroy', $d->idvendor) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Hapus data ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
      </form>
    </td>
    @endif
  </tr>
  @endforeach
</table>
@endsection
