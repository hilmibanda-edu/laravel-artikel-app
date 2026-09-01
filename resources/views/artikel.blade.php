<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="d-flex justify-content-end mb-3">
    @auth
        <!-- Jika User Sudah Login -->
        <span class="me-3 align-self-center">Halo, <strong>{{ Auth::user()->name }}</strong></span>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
    @else
        <!-- Jika User Belum Login -->
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
    @endauth
    </div>
    <title>Daftar Artikel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary">Daftar Artikel</h2>
                    <a href="/artikel/tambah" class="btn btn-primary">+ Tambah Artikel</a>
                </div>

                <!-- Notifikasi Sukses -->
                @if (session('sukses'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('sukses') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Loop Artikel -->
                @forelse ($artikels as $item)
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <!-- Tampilkan gambar jika ada -->
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid rounded mb-3" style="max-height: 250px; width: 100%; object-fit: cover;" alt="{{ $item->judul }}">
                            @endif

                            <h4 class="card-title text-dark">{{ $item->judul }}</h4>
                            <p class="card-text text-secondary">{{ $item->isi }}</p>
                            <small class="text-muted d-block mb-3">
                                Dibuat pada: {{ $item->created_at->format('d M Y, H:i') }} WIB
                            </small>
                            
                            <div class="d-flex gap-2">
                                <a href="/artikel/{{ $item->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                                <form action="/artikel/{{ $item->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- ... -->
                @endforelse

            </div>
        </div>
    </div>

    <!-- Bootstrap JS (untuk menutup alert otomatis) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>