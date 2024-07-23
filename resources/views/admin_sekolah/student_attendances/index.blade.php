@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h1>Data Rekap Presensi Siswa</h1>
    <a href="{{ route('student_attendances.create') }}" class="btn btn-primary mb-3">Tambah Presensi</a>
    <table class="table table-bordered" id="tabel">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>No Absen</th>
                <th>Jurusan</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Gambar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $attendance->nis }}</td>
                    <td>{{ $attendance->siswa->nama }}</td>
                    <td>{{ $attendance->siswa->no_absen }}</td>
                    <td>{{ $attendance->siswa->jurusan }}</td>
                    <td>{{ $attendance->siswa->kelas }}</td>
                    <td>{{ $attendance->tanggal }}</td>
                    <td>{{ ucfirst($attendance->status) }}</td>
                    <td>
                        @if($attendance->gambar)
                            <img src="{{ asset('storage/' . $attendance->gambar) }}" alt="Gambar" width="100">
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
