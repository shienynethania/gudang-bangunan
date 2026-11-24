@extends('layout')

@section('content')
<div class="text-center mt-5">
  <h1 class="display-4">403</h1>
  <p class="lead">{{ $exception->getMessage() ?: 'Anda tidak punya akses ke halaman ini' }}</p>
  <a href="{{ url('/') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
