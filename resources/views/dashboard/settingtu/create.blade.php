@extends('layouts.adminmaster')
@section('content')
<div class="container">
    <h1>Create New Setting</h1>
    <form action="{{ route('dashboard.settingtu.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="in_start">In Start</label>
            <input type="time" class="form-control @error('in_start') is-invalid @enderror" id="in_start" name="in_start" value="{{ old('in_start') }}" required>
            @error('in_start')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="in_end">In End</label>
            <input type="time" class="form-control @error('in_end') is-invalid @enderror" id="in_end" name="in_end" value="{{ old('in_end') }}" required>
            @error('in_end')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="out_start">Out Start</label>
            <input type="time" class="form-control @error('out_start') is-invalid @enderror" id="out_start" name="out_start" value="{{ old('out_start') }}" required>
            @error('out_start')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="out_end">Out End</label>
            <input type="time" class="form-control @error('out_end') is-invalid @enderror" id="out_end" name="out_end" value="{{ old('out_end') }}" required>
            @error('out_end')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create Setting</button>
    </form>
</div>
@endsection