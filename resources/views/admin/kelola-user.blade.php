@extends('layout-admin')

@section('judul-halaman')
    Halaman - Kelola User
@endsection

@section('konten-utama')
    @if (session('pesan_berhasil'))
        <div class="alert alert-success" role="alert">
            {{ session('pesan_berhasil') }}
        </div>
    @endif
    @if (session('pesan_gagal'))
        <div class="alert alert-danger" role="alert">
            {{ session('pesan_gagal') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            {{ $errors->first() }}
        </div>
    @endif
    <div class="container-fluid bg-white">
        <h1 class="text-center fw-bold">Kelola User</h1>
    </div>
    <div class="container">
        <form action="" method="post">
            @csrf
            <input type="hidden" id="id_user" name="id_user">
            <div class="row mt-4">
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <div style="width: 85%;">
                        <div>
                            <label for="tipe_user" class="form-label fw-semibold">Tipe User</label>
                            <select class="form-select fw-semibold bg-body-secondary" id="tipe_user" name="tipe_user"
                                style="background-color: #e6ecf1;">
                                <option value=""> - Pilih Tipe - </option>
                                <option value="gudang" {{ old('tipe_user') == 'gudang' ? 'selected' : '' }}>Gudang</option>
                                <option value="kasir" {{ old('tipe_user') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                        </div>
                        <div>
                            <label for="nama" class="form-label fw-semibold mt-3">Nama</label>
                            <input type="text" class="form-control fw-semibold bg-body-secondary" id="nama"
                                name="nama" value="{{ old('nama') }}" style="background-color: #e6ecf1;">
                        </div>
                        <div>
                            <label for="telepon" class="form-label fw-semibold mt-3">Telepon</label>
                            <input type="text" class="form-control fw-semibold bg-body-secondary" id="telepon"
                                name="telepon" value="{{ old('telepon') }}" style="background-color: #e6ecf1;">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <div style="width: 85%;">
                        <div>
                            <label for="alamat" class="form-label fw-semibold">Alamat</label>
                            <input type="text" class="form-control fw-semibold bg-body-secondary" id="alamat"
                                name="alamat" value="{{ old('alamat') }}" style="background-color: #e6ecf1;">
                        </div>
                        <div>
                            <label for="username" class="form-label fw-semibold mt-3">Username</label>
                            <input type="text" class="form-control fw-semibold bg-body-secondary" id="username"
                                name="username" value="{{ old('username') }}" style="background-color: #e6ecf1;">
                        </div>
                        <div>
                            <label for="password" class="form-label fw-semibold mt-3">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control fw-semibold bg-body-secondary" id="password"
                                    name="password" value="{{ old('password') }}" style="background-color: #e6ecf1;">
                                <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer; background-color: #e6ecf1;">
                                    <i class="fa fa-eye text-primary" id="eyeIcon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3" style="width: 100%; margin-left: 36px">
                    <button type="submit" name="action" value="tambah" class="btn btn-info fw-semibold me-3" style="width: 117px;">Tambah</button>
                    <button type="submit" name="action" value="edit" class="btn btn-info fw-semibold me-3" style="width: 117px;">Edit</button>
                    <button type="submit" name="action" value="hapus" class="btn btn-info fw-semibold" style="width: 117px;">Hapus</button>
                </div>
            </div>
        </form>

        <div class="mt-3" style="width: 389px; margin-left: 36px">
            <form action="" method="get">
                <div class="input-group">
                    <input type="text" name="cari" class="form-control bg-body-secondary" placeholder="Cari user"
                        style="background-color: #e6ecf1;" value="{{ request('cari') }}">
                    <button class="btn" type="submit" style="background-color: #e6ecf1">
                        <i class="fa fa-search text-info"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center" id="user_table">
                <thead class="table-light">
                    <tr>
                        <th>Id User</th>
                        <th>Tipe User</th>
                        <th>Nama User</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_user as $index => $du)
                        <tr
                            onclick="handleRowClick(event, {{ $du['id_user'] }}, '{{ $du['tipe_user'] }}', '{{ $du['nama'] }}', '{{ $du['telepon'] }}', '{{ $du['alamat'] }}', '{{ $du['username'] }}', '{{ $du['password'] }}')">
                            <td>{{ $du['id_user'] }}</td>
                            <td>{{ $du['tipe_user'] }}</td>
                            <td>{{ $du['nama'] }}</td>
                            <td>{{ $du['alamat'] }}</td>
                            <td>{{ $du['telepon'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $data_user->links() }}
            </div>
        </div>
    </div>

    <script>
        function handleRowClick(event, id_user, tipe_user, nama, telepon, alamat, username, password) {
            document.querySelectorAll('#user_table tbody tr').forEach(tr => {
                tr.classList.remove('table-primary');
            });
            event.currentTarget.classList.add('table-primary');

            select_row(id_user, tipe_user, nama, telepon, alamat, username, password);
        }

        function select_row(id_user, tipe_user, nama, telepon, alamat, username, password) {
            document.getElementById('id_user').value = id_user;
            document.getElementById('tipe_user').value = tipe_user;
            document.getElementById('nama').value = nama;
            document.getElementById('telepon').value = telepon;
            document.getElementById('alamat').value = alamat;
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
        }

        function togglePassword() {
            const input = document.getElementById("password");
            const icon = document.getElementById("eyeIcon");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
