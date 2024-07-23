@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Siswa</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" class="form-control" value="{{ $siswa->nis }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="no_absen">No Absen</label>
                        <input type="text" name="no_absen" class="form-control" value="{{ $siswa->no_absen }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" value="{{ $siswa->jurusan }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" name="kelas" class="form-control" value="{{ $siswa->kelas }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="status">Keterangan</label>
                        <input type="text" name="status" class="form-control" value="{{ $siswa->status }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="uid_rfid">UID RFID</label>
                        <input type="text" name="uid_rfid" class="form-control" value="{{ $siswa->uid_rfid }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="gambar">Gambar</label>
                        @if($siswa->gambar)
                        <img src="{{ asset('storage/'.$siswa->gambar) }}" alt="{{ $siswa->nama }}" width="100">
                        @else
                        -
                        @endif
                    </div>
                    <a href="{{ route('admin_sekolah.manajemendatasiswa') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
