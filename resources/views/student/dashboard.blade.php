@extends('layouts.siswamaster')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <h1>Selamat Datang {{ $student->nama }} di Website SI PRESTIK</h1>
        </div>
    </div>

    <form action="{{ route('siswa.dashboard') }}" method="GET" class="mb-3">
        <div class="form-group">
            <label for="month">Pilih Bulan:</label>
            <select name="month" id="month" class="form-control" onchange="this.form.submit()">
                @foreach($monthsList as $value => $label)
                    <option value="{{ $value }}" {{ $value == $selectedMonth ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <h2>Data Kehadiran Bulan {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</h2>

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $hadir }}</h3>
                    <p>Hadir</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $sakit }}</h3>
                    <p>Sakit</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $izin }}</h3>
                    <p>Izin</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $alpha }}</h3>
                    <p>Alpha</p>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row mt-4">
        <div class="col-12">
            <h3>Riwayat Kehadiran Terakhir</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $attendance)
                    <tr>
                        <td>{{ $attendance->date }}</td>
                        <td>{{ $attendance->time }}</td>
                        <td>{{ ucfirst($attendance->information) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> -->
</div>
@endsection