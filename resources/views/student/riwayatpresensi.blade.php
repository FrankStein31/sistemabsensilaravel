@extends('layouts.siswamaster')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">Riwayat Presensi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.riwayatPresensi') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                    <table id="tabel" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Status</th>
                                <th>Gambar Masuk</th>
                                <th>Gambar Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allAttendances as $attendance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attendance['date'] }}</td>
                                <td>{{ $attendance['waktu_masuk'] ?? '-' }}</td>
                                <td>{{ $attendance['waktu_keluar'] ?? '-' }}</td>
                                <td>{{ $attendance['status'] }}</td>
                                <td>
                                    @if($attendance['type'] == 'attendance' && $attendance['image_masuk'])
                                        <img src="{{ asset('storage/'.$attendance['image_masuk']) }}" alt="Masuk" width="50">
                                    @elseif($attendance['type'] == 'student_attendance' && $attendance['gambar'])
                                        <img src="{{ asset('storage/'.$attendance['gambar']) }}" alt="Bukti" width="50">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($attendance['type'] == 'attendance' && $attendance['image_keluar'])
                                        <img src="{{ asset('storage/'.$attendance['image_keluar']) }}" alt="Keluar" width="50">
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection