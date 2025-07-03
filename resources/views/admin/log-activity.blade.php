@extends('layout-admin')

@section('judul-halaman')
    Halaman - Log Activity
@endsection

@section('konten-utama')
    <div class="container-fluid bg-white">
        <h1 class="text-center fw-bold mb-0">Log Activity</h1>
    </div>

    <div class="container my-5">
        <form method="GET">
            <h4>Pilih Tanggal</h4>
            <div class="d-flex gap-2 flex-wrap">
                <input type="date" id="tanggal" name="tanggal" class="form-control" style="max-width: 200px;" value="{{ request('tanggal') }}">
                <button type="submit" class="btn btn-info px-5">Filter</button>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ID Log</th>
                        <th scope="col">Username</th>
                        <th scope="col">Waktu</th>
                        <th scope="col">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data_log as $dl)
                        <tr>
                            <td>{{ $dl->id_log }}</td>
                            <td>{{ $dl->user->username ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($dl->created_at)->translatedFormat('l, d F Y') }}</td>
                            <td>{{ $dl->aktivitas }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $data_log->appends(['tanggal' => request('tanggal')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
