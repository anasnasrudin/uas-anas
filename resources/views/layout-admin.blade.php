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
        <div id="sidebar" class="px-3 bg-info bg-opacity-25" style="height: 100vh;">
            <div class="d-flex flex-column align-items-center justify-content-center h-100 gap-3">
                <h1 class="text-black fw-bold">Admin</h1>
                <a href="{{ url('Admin/LogActivity') }}">
                    <img src="/assets/img/admin.png" alt="Admin Image" width="120">
                </a>
                <div class="d-flex flex-column gap-2 mt-3 w-100">
                    <a href="KelolaUser" class="btn btn-info w-75 fw-semibold mx-auto">Kelola User</a>
                    <a href="KelolaLaporan" class="btn btn-info w-75 fw-semibold mx-auto">Kelola Laporan</a>
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
    <script src="/assets/js/chart.min.js"></script>
    @yield('custom-js')
</body>

</html>
