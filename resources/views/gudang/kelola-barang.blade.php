@extends('layout-gudang')

@section('judul-halaman')
    Halaman - Kelola Barang
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
    <div class="container-fluid bg-white pt-4 pb-4">
        <h1 class="text-center fw-bold">Kelola Barang</h1>
    </div>
    <div class="container">
        <form action="" method="post">
            @csrf
            <input type="hidden" id="id_barang" name="id_barang">
            <div class="row mt-4">
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <div style="width: 100%;">
                        <div>
                            <label for="kode_barang" class="form-label fw-semibold">Kode Barang</label>
                            <input type="text" class="form-control bg-body-secondary" id="kode_barang" name="kode_barang"
                                value="{{ old('kode_barang') }}" style="background-color: #e6ecf1;">
                        </div>
                        <div>
                            <label for="nama_barang" class="form-label fw-semibold mt-3">Nama Barang</label>
                            <input type="text" class="form-control bg-body-secondary" id="nama_barang" name="nama_barang"
                                value="{{ old('nama_barang') }}" style="background-color: #e6ecf1;">
                        </div>
                        <div>
                            <label for="expired_date" class="form-label fw-semibold mt-3">Expired Date</label>
                            <input type="date" class="form-control bg-body-secondary" id="expired_date"
                                name="expired_date" value="{{ old('expired_date') }}" style="background-color: #e6ecf1;">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <div style="width: 100%;">
                        <div>
                            <label for="jumlah_barang" class="form-label fw-semibold">Jumlah Barang</label>
                            <input type="number" class="form-control bg-body-secondary" id="jumlah_barang"
                                name="jumlah_barang" value="{{ old('jumlah_barang') }}" style="background-color: #e6ecf1;">
                        </div>
                        <div>
                            <label for="satuan" class="form-label fw-semibold mt-3">Satuan</label>
                            <select class="form-select bg-body-secondary" id="satuan" name="satuan"
                                style="background-color: #e6ecf1;">
                                <option value=""> - Pilih Satuan - </option>
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
                                <option value="dus" {{ old('satuan') == 'dus' ? 'selected' : '' }}>Dus</option>
                            </select>
                        </div>
                        <div>
                            <label for="harga_satuan" class="form-label fw-semibold mt-3">Harga Per Satuan</label>
                            <input type="text" class="form-control bg-body-secondary" id="harga_satuan"
                                name="harga_satuan" value="{{ old('harga_satuan') }}" style="background-color: #e6ecf1;">
                        </div>
                    </div>
                </div>
                <div class="mt-3" style="width: 100%;">
                    <button type="submit" name="action" value="tambah" class="btn btn-info fw-semibold me-3"
                        style="width: 119px;">Tambah</button>
                    <button type="submit" name="action" value="edit" class="btn btn-info fw-semibold me-3"
                        style="width: 118px;">Edit</button>
                    <button type="submit" name="action" value="hapus" class="btn btn-info fw-semibold"
                        style="width: 119px;">Hapus</button>
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <h5 class="fw-semibold mb-2">Tabel Stock Barang</h5>
            <div style="width: 250px;">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" name="cari" class="form-control bg-body-secondary"
                            placeholder="Cari nama barang" style="background-color: #e6ecf1;">
                        <button class="btn" type="submit" style="background-color: #e6ecf1;">
                            <i class="fa fa-search text-info"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered text-center" id="barang_table">
                <thead class="table-light">
                    <tr>
                        <th>ID Barang</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Expired Date</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_barang as $index => $db)
                        <tr
                            onclick="handleRowClick(event, {{ $db['id_barang'] }}, '{{ $db['kode_barang'] }}', '{{ $db['nama_barang'] }}', '{{ $db['expired_date'] }}', '{{ $db['jumlah_barang'] }}', '{{ $db['satuan'] }}', '{{ $db['harga_satuan'] }}')">
                            <td>{{ $db['id_barang'] }}</td>
                            <td>{{ $db['kode_barang'] }}</td>
                            <td>{{ $db['nama_barang'] }}</td>
                            <td>{{ $db['expired_date'] }}</td>
                            <td>{{ $db['jumlah_barang'] }}</td>
                            <td>{{ $db['satuan'] }}</td>
                            <td>Rp. {{ number_format($db['harga_satuan'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $data_barang->links() }}
            </div>
        </div>
    </div>

    <script>
        function handleRowClick(event, id_barang, kode_barang, nama_barang, expired_date, jumlah_barang, satuan, harga_satuan) {
            document.querySelectorAll('#barang_table tbody tr').forEach(tr => {
                tr.classList.remove('table-primary');
            });
            event.currentTarget.classList.add('table-primary');
    
            select_row(id_barang, kode_barang, nama_barang, expired_date, jumlah_barang, satuan, harga_satuan);
        }
    
        function select_row(id_barang, kode_barang, nama_barang, expired_date, jumlah_barang, satuan, harga_satuan) {
            document.getElementById('id_barang').value = id_barang;
            document.getElementById('kode_barang').value = kode_barang;
            document.getElementById('nama_barang').value = nama_barang;
            document.getElementById('expired_date').value = expired_date;
            document.getElementById('jumlah_barang').value = jumlah_barang;
            document.getElementById('satuan').value = satuan;
            document.getElementById('harga_satuan').value = harga_satuan;
        }
    </script>
@endsection