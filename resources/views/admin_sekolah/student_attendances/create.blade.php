@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <h1>Tambah Presensi Siswa</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Perhatian!</strong> Mohon periksa kembali input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('student_attendances.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nis">NIS</label>
            <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis" name="nis" required>
            @error('nis')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" disabled>
        </div>
        <div class="form-group">
            <label for="no_absen">No Absen</label>
            <input type="text" class="form-control" id="no_absen" disabled>
        </div>
        <div class="form-group">
            <label for="jurusan">Jurusan</label>
            <input type="text" class="form-control" id="jurusan" disabled>
        </div>
        <div class="form-group">
            <label for="kelas">Kelas</label>
            <input type="text" class="form-control" id="kelas" disabled>
        </div>
        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="datetime-local" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" required>
            @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="alpha">Alpha</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group" id="gambar-group" style="display: none;">
            <label for="gambar">Upload Gambar</label>
            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    document.getElementById('status').addEventListener('change', function () {
        var gambarGroup = document.getElementById('gambar-group');
        if (this.value === 'izin' || this.value === 'sakit') {
            gambarGroup.style.display = 'block';
        } else {
            gambarGroup.style.display = 'none';
        }
    });

    document.getElementById('nis').addEventListener('input', function () {
        var nis = this.value;
        if (nis.length >= 8) {
            fetch(`/api/siswa/${nis}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('nama').value = data.nama;
                    document.getElementById('no_absen').value = data.no_absen;
                    document.getElementById('jurusan').value = data.jurusan;
                    document.getElementById('kelas').value = data.kelas;
                });
        }
    });
</script>
@endsection
