<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('judul-halaman')</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/template-2.css">
</head>

<body>
    <main class="d-flex vh-100 w-100">
        <div id="sidebar" class="px-3" style="background-color: #d6f0ff; height: 100vh;">
            <div class="d-flex flex-column align-items-center justify-content-center h-100 gap-3">
                <h3 class="fw-bold text-black" style="margin-bottom: 50px">KASIR</h3>
                <img src="/assets/img/kasir.png" alt="Kasir Image" width="120" style="margin-bottom: 50px">
                <h3 class="fw-bold text-center mb-0">KELOLA<br>TRANSAKSI</h3>
                <div style="height: 50px;"></div>
                <div class="d-flex flex-column w-100">
                    <form action="{{ url('logout') }}" method="POST" class="w-100 d-flex justify-content-center">
                        @csrf
                        <button type="submit" class="btn btn-info w-75 fw-semibold mx-auto">Logout</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="main-content" class="bg-white my-4">
            <div class="container-fluid my-4">
                @yield('konten-utama')
            </div>
        </div>
    </main>
</body>

</html>
