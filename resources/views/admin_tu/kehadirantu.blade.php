@extends('layouts.adminmaster')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8 text-end">
            <a href="{{ route('admin.tu.download.excel', request()->query()) }}" class="btn btn-success" id="download-excel">Unduh Excel</a>
        </div>
        <div class="col-md-4">
            <form action="{{ route('admin_tu.kehadiran') }}" method="GET" id="filter-form">
                <div class="input-group">
                    <select name="kelas" class="form-select me-2" style="width: 250px;">
                        <option value="">Semua Kelas</option>
                        <option value="12 Teknik Komputer dan Jaringan (TKJ) 1" {{ request('kelas') == '12 Teknik Komputer dan Jaringan (TKJ) 1' ? 'selected' : '' }}>12 Teknik Komputer dan Jaringan 1</option>
                        <option value="12 Teknik Komputer dan Jaringan (TKJ) 2" {{ request('kelas') == '12 Teknik Komputer dan Jaringan (TKJ) 2' ? 'selected' : '' }}>12 Teknik Komputer dan Jaringan 2</option>
                        <option value="12 Teknik Komputer dan Jaringan (TKJ) 3" {{ request('kelas') == '12 Teknik Komputer dan Jaringan (TKJ) 3' ? 'selected' : '' }}>12 Teknik Komputer dan Jaringan 3</option>
                    </select>
                    <input type="date" name="date" class="form-control me-2" style="width: 300px;" placeholder="Pilih Tanggal" value="{{ request('date') }}">
                    <input type="text" name="search" class="form-control me-2" style="width: 300px;" placeholder="Cari NIS, Nama, Kelas" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cek Kehadiran Siswa - {{ request('date', now()->toDateString()) }}</h3>
                </div>
                <div class="card-body">
                    <table id="tabel" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>UID RFID</th>
                                <th>Nama</th>
                                <th>No Absen</th>
                                <th>Jurusan</th>
                                <th>Kelas</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Gambar Masuk</th>
                                <th>Gambar Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attendance->siswa->nis }}</td>
                                <td>{{ $attendance->siswa->uid_rfid }}</td>
                                <td>{{ $attendance->siswa->nama }}</td>
                                <td>{{ $attendance->siswa->no_absen }}</td>
                                <td>{{ $attendance->siswa->jurusan }}</td>
                                <td>{{ $attendance->siswa->kelas }}</td>
                                <td>{{ $attendance->waktu_masuk ?: '-' }}</td>
                                <td>{{ $attendance->waktu_keluar ?: '-' }}</td>
                                <td>{{ $attendance->status }}</td>
                                <td>{{ $attendance->keterangan }}</td>
                                <td>
                                    @if($attendance->image_masuk)
                                        <img src="{{ asset($attendance->image_masuk) }}" alt="Masuk" width="50">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->image_keluar)
                                        <img src="{{ asset($attendance->image_keluar) }}" alt="Keluar" width="50">
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

<script>
    document.getElementById('download-excel').addEventListener('click', function () {
        var form = document.getElementById('filter-form');
        form.action = "{{ route('admin_tu.kehadiran.downloadExcel') }}";
        form.submit();
    });
</script>
@endsection
