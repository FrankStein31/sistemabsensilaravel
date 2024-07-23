@extends('layouts.master')
@section('content')
<div class="container-fluid">
    <h2>Dashboard Bulan {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</h2>
    
    <form action="{{ route('admin_sekolah.dashboard') }}" method="GET" class="mb-3">
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

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $total_siswa }}</h3>
                    <p>Jumlah Siswa</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $hadir }}</h3>
                    <p>Total Kehadiran</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $sakit }}</h3>
                    <p>Total Sakit</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $izin }}</h3>
                    <p>Total Izin</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $alpha }}</h3>
                    <p>Total Alpha</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection