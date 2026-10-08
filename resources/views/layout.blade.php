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
        {{-- tambah link menu baru di sini setiap selesai satu CRUD --}}
        <a class="nav-link" href="{{ route('role.index') }}">Role</a>
      </div>
    </div>
  </nav>
  <div class="container">
    @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
    @if(session('err')) <div class="alert alert-danger">{{ session('err') }}</div> @endif
    @yield('content')
  </div>
</body>
</html>
