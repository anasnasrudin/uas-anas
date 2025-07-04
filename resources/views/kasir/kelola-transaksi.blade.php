@extends('layout-kasir')

@section('judul-halaman')
    Halaman - Kelola Transaksi
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
    <div class="container-fluid bg-white pb-4">
        <h2 class="ms-4 fw-bold">Form Transaksi</h2>
        <div class="ms-4">
            <span class="badge text-bg-danger fw-semibold">
                {{ Auth::guard('udin')->user()->nama }}
            </span>
        </div>
    </div>
    <div class="container mt-3" id="print-area">
        <form action="" method="POST">
            @csrf
            <input type="hidden" name="kode_barang" id="kode_barang">
            <input type="hidden" name="nama_barang" id="nama_barang">
            <div class="row">
                <div class="col-md-6 d-flex flex-column align-items-center">
                    <div style="width: 90%;">
                        <label class="form-label fw-semibold">Pilih Menu</label>
                        <select class="form-select bg-body-secondary" name="menu_id" id="menu_id"
                            style="background-color: #e6ecf1;">
                            <option value="">Kode - Nama Menu</option>
                            @foreach ($data_barang as $barang)
                                <option value="{{ $barang->id_barang }}" data-harga="{{ $barang->harga_satuan }}"
                                    data-kode="{{ $barang->kode_barang }}" data-nama="{{ $barang->nama_barang }}">
                                    {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form-label fw-semibold mt-3">Harga Satuan</label>
                        <input type="text" id="harga_satuan" name="harga_satuan" class="form-control bg-body-secondary"
                            readonly style="background-color: #e6ecf1;">
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-column">
                    <div style="width: 90%;">
                        <label class="form-label fw-semibold">Quantitas</label>
                        <input type="number" id="quantitas" name="jumlah" class="form-control bg-body-secondary"
                            style="background-color: #e6ecf1;">

                        <label class="form-label fw-semibold mt-3">Total Harga</label>
                        <input type="text" id="total_harga" class="form-control bg-body-secondary" readonly
                            style="background-color: #e6ecf1;">
                    </div>
                </div>
            </div>
            <div class="mt-4" style="margin-left: 68%">
                <button type="submit" name="action" value="tambah" class="btn btn-info fw-semibold me-2"
                    style="width: 120px">Tambah</button>
                <button type="submit" name="action" value="reset" class="btn btn-info fw-semibold"
                    style="width: 120px">Reset</button>
            </div>
        </form>
        <h6 class="fw-semibold mt-4">Keranjang</h6>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Quantitas</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keranjang as $index => $item)
                        <tr>
                            <td>{{ 'TSI-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $item['kode_barang'] }}</td>
                            <td>{{ $item['nama_barang'] }}</td>
                            <td>Rp. {{ number_format($item['harga_satuan'], 0, ',', '.') }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @php $total_harga = collect($keranjang)->sum('subtotal'); @endphp
        <div class="row" style="margin-left: 35px">
            <div class="col-md-5">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="bayar">
                    <div class="p-3" style="background-color: #f9f9f9;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Total Harga</h5>
                            <h5 class="mb-0 fw-bold">Rp. {{ number_format($total_harga, 0, ',', '.') }}</h5>
                        </div>
                        <div class="mb-3">
                            <input type="number" name="nominal_bayar" class="form-control bg-body-secondary"
                                placeholder="Masukkan nominal bayar" style="background-color: #e6ecf1;">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-info fw-semibold w-100">Bayar</button>
                        </div>
                        @if (!is_null($kembalian))
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Kembalian</h5>
                                <h5 class="mb-0 fw-bold">Rp. {{ number_format($kembalian, 0, ',', '.') }}</h5>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="action" value="simpan">
                    <input type="hidden" name="total_harga" value="{{ $total_harga }}">
                    <div class="d-flex align-items-end gap-2" style="margin-top: 97px; margin-left: 100px;">
                        <button type="button" id="btn-print" class="btn btn-info fw-semibold"
                            style="width: 150px;">Print</button>
                        <button type="submit" class="btn btn-info fw-semibold" style="width: 150px;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            #btn-print {
                display: none;
            }
        }
    </style>

    <script>
        const menuSelect = document.getElementById('menu_id');
        const hargaInput = document.getElementById('harga_satuan');
        const kodeInput = document.getElementById('kode_barang');
        const namaInput = document.getElementById('nama_barang');
        const qtyInput = document.getElementById('quantitas');
        const totalInput = document.getElementById('total_harga');

        menuSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const harga = selected.getAttribute('data-harga');
            const kode = selected.getAttribute('data-kode');
            const nama = selected.getAttribute('data-nama');
            hargaInput.value = harga;
            kodeInput.value = kode;
            namaInput.value = nama;
            updateTotal();
        });

        qtyInput.addEventListener('input', updateTotal);

        function updateTotal() {
            const harga = hargaInput.value;
            const qty = qtyInput.value;
            if (harga && qty) {
                totalInput.value = parseInt(harga) * parseInt(qty);
            } else {
                totalInput.value = '';
            }
        }

        document.getElementById('btn-print').addEventListener('click', function () {
            window.print();
        });
    </script>
@endsection
