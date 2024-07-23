@extends('layouts.adminmaster')

@section('content')
<div class="container-fluid">

<h2>Dashboard Bulan {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</h2>
    
    <form action="{{ route('admin_tu.dashboard') }}" method="GET" class="mb-3">
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
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4 class="card-title">Jumlah Siswa</h4>
                    <p class="card-text">{{ $total_siswa }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-blue text-white">
                <div class="card-body">
                    <h4 class="card-title">Siswa Hadir</h4>
                    <p class="card-text">{{ $hadir }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-yellow text-white">
                <div class="card-body">
                    <h4 class="card-title">Siswa Sakit</h4>
                    <p class="card-text">{{ $sakit }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-green text-white">
                <div class="card-body">
                    <h4 class="card-title">Siswa Izin</h4>
                    <p class="card-text">{{ $izin }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-red text-white">
                <div class="card-body">
                    <h4 class="card-title">Siswa Alpha</h4>
                    <p class="card-text">{{ $alpha }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
