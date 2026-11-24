@extends('layout')
@section('content')
<h4>Pengadaan Baru - Langkah 1: Pilih Vendor</h4>
<form action="{{ route('pengadaan.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label class="form-label">Vendor</label>
    <select name="idvendor" class="form-select" required>
      <option value="">-- pilih vendor --</option>
      @foreach($vendor as $v)
        <option value="{{ $v->idvendor }}" @selected(old('idvendor') == $v->idvendor)>{{ $v->nama_vendor }}</option>
      @endforeach
    </select>
  </div>
  <button class="btn btn-primary">Next &rarr;</button>
  <a href="{{ route('pengadaan.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
