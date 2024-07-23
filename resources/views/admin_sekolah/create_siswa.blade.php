@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Siswa</h3>
                </div>
                <div class="card-body">
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

                    <form action="{{ route('admin_sekolah.siswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" required>
                            @error('nis')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_absen">No Absen</label>
                            <input type="text" name="no_absen" class="form-control @error('no_absen') is-invalid @enderror" value="{{ old('no_absen') }}" required>
                            @error('no_absen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <input type="text" name="jurusan" value="Teknik Komputer dan Jaringan (TKJ)" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select name="kelas" id="kelas" class="form-control @error('kelas') is-invalid @enderror" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="12 Teknik Komputer dan Jaringan (TKJ) 1" {{ old('kelas') == '12 Teknik Komputer dan Jaringan (TKJ) 1' ? 'selected' : '' }}>12 Teknik Komputer dan Jaringan (TKJ) 1</option>
                                <option value="12 Teknik Komputer dan Jaringan (TKJ) 2" {{ old('kelas') == '12 Teknik Komputer dan Jaringan (TKJ) 2' ? 'selected' : '' }}>12 Teknik Komputer dan Jaringan (TKJ) 2</option>
                                <option value="12 Teknik Komputer dan Jaringan (TKJ) 3" {{ old('kelas') == '12 Teknik Komputer dan Jaringan (TKJ) 3' ? 'selected' : '' }}>12 Teknik Komputer dan Jaringan (TKJ) 3</option>
                            </select>
                            @error('kelas')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="uid_rfid">UID RFID</label>
                            <input type="text" name="uid_rfid" id="uid_rfid" class="form-control @error('uid_rfid') is-invalid @enderror" value="{{ old('uid_rfid') }}" required readonly>
                            <button type="button" class="btn btn-primary mt-2" id="tapRfidButton">Tap RFID</button>
                            @error('uid_rfid')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="face_image">Gambar Wajah</label>
                            <input type="file" name="face_image" class="form-control @error('face_image') is-invalid @enderror" required>
                            @error('face_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success" id="submitButton" disabled>Simpan</button>
                        <a href="{{ route('admin_sekolah.manajemendatasiswa') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tapRfidButton = document.getElementById('tapRfidButton');
        const uidRfidInput = document.getElementById('uid_rfid');
        const submitButton = document.getElementById('submitButton');

        tapRfidButton.addEventListener('click', function () {
            fetch('/get-rfid-uid')
                .then(response => response.json())
                .then(data => {
                    uidRfidInput.value = data.uid_rfid;
                    submitButton.disabled = false; // Enable the submit button after RFID is fetched
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection
