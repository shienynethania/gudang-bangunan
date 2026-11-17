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
      <div class="navbar-nav">
        <a class="nav-link" href="{{ route('satuan.index') }}">Satuan</a>
        <a class="nav-link" href="{{ route('role.index') }}">Role</a>
        <a class="nav-link" href="{{ route('barang.index') }}">Barang</a>
        <a class="nav-link" href="{{ route('user.index') }}">User</a>
        <a class="nav-link" href="{{ route('margin.index') }}">Margin</a>
        <a class="nav-link" href="{{ route('vendor.index') }}">Vendor</a>
        <a class="nav-link" href="{{ route('pengadaan.index') }}">Pengadaan</a>
        <a class="nav-link" href="{{ route('penerimaan.index') }}">Penerimaan</a>
        <a class="nav-link" href="{{ route('penjualan.index') }}">Penjualan</a>
        <a class="nav-link" href="{{ route('ringkasan.index') }}">Ringkasan</a>
      </div>
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
