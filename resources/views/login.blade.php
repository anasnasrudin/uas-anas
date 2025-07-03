<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/template-2.css">
</head>

<body>
    <div class="container bg-white d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card border-0 shadow-none p-4" style="min-width: 330px; background-color: transparent;">
            @if (session('pesan'))
                <div class="alert alert-danger" role="alert">
                    {{ session('pesan') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif
            <form action="{{ url('login') }}" method="post">
                @csrf
                <div class="d-flex justify-content-center">
                    <img src="/assets/img/store.png" alt="Store Image" width="150">
                </div>
                <div class="d-flex justify-content-center gap-2 mt-3">
                    <h1 class="fw-bold">Food XYZ</h1>
                </div>
                <div>
                    <label for="username" class="form-label"></label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="User Name"
                        style="background-color: #e6ecf1" value="{{ old('username') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                        style="background-color: #e6ecf1">
                </div>
                <div class="d-flex justify-content-between gap-2 mt-3">
                    <button type="submit" class="btn btn-info opacity-75 w-50 fw-semibold">Login</button>
                    <button type="reset" class="btn text-dark w-50 fw-semibold"
                        style="background-color: #aeb8c0;">Reset</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
