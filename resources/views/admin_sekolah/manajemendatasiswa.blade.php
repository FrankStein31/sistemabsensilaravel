@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Data Siswa</h3>
                    <a href="{{ route('admin_sekolah.create_siswa') }}" class="btn btn-primary float-right">Tambah Siswa</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>No Absen</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th>UID RFID</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswas as $siswa)
                                <tr>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->no_absen }}</td>
                                    <td>{{ $siswa->jurusan }}</td>
                                    <td>{{ $siswa->kelas }}</td>
                                    <td>{{ $siswa->uid_rfid }}</td>
                                    <td>
                                        @if ($siswa->gambar)
                                            <img src="{{ asset('storage/' . $siswa->gambar) }}" alt="Gambar Siswa" style="inline-size: 100px; block-size: auto;">
                                        @else
                                            Tidak ada gambar
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin_sekolah.edit_siswa', $siswa->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('admin_sekolah.destroy_siswa', $siswa->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Hapus</button>
                                        </form>
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
