@php
  $role  = (int) session('idrole');
  $boleh = fn(array $r) => in_array($role, $r);
@endphp
<!DOCTYPE html>
<html>
<head>
  <title>Gudang Bahan Bangunan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand navbar-dark bg-dark mb-4">
    <div class="container">
      <span class="navbar-brand">Gudang Bahan Bangunan</span>
      @if(session('iduser'))
      <div class="navbar-nav me-auto">
        @if($boleh([1,2,3]))   <a class="nav-link" href="{{ route('satuan.index') }}">Satuan</a> @endif
        @if($boleh([1]))       <a class="nav-link" href="{{ route('role.index') }}">Role</a> @endif
        @if($boleh([1,2,3,4])) <a class="nav-link" href="{{ route('barang.index') }}">Barang</a> @endif
        @if($boleh([1]))       <a class="nav-link" href="{{ route('user.index') }}">User</a> @endif
        @if($boleh([1]))       <a class="nav-link" href="{{ route('margin.index') }}">Margin</a> @endif
        @if($boleh([1,2,3]))   <a class="nav-link" href="{{ route('vendor.index') }}">Vendor</a> @endif
        @if($boleh([1,2,3]))   <a class="nav-link" href="{{ route('pengadaan.index') }}">Pengadaan</a> @endif
        @if($boleh([1,2,3]))   <a class="nav-link" href="{{ route('penerimaan.index') }}">Penerimaan</a> @endif
        @if($boleh([1,4]))     <a class="nav-link" href="{{ route('penjualan.index') }}">Penjualan</a> @endif
        @if($boleh([1,2]))     <a class="nav-link" href="{{ route('kartustok.index') }}">Kartu Stok</a> @endif
        @if($boleh([1,2]))     <a class="nav-link" href="{{ route('ringkasan.index') }}">Ringkasan</a> @endif
      </div>
      <div class="d-flex align-items-center">
        <span class="navbar-text me-3">{{ session('username') }} ({{ session('nama_role') }})</span>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-sm btn-outline-light">Keluar</button>
        </form>
      </div>
      @else
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="{{ route('login') }}">Login</a>
        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
      </div>
      @endif
    </div>
  </nav>
  <div class="container">
    @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
    @if(session('err')) <div class="alert alert-danger">{{ session('err') }}</div> @endif
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif
    @yield('content')
  </div>
</body>
</html>
