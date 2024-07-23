@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Settings</h1>
    <table class="table">
        <thead>
            <tr>
                <th>In Start</th>
                <th>In End</th>
                <th>Out Start</th>
                <th>Out End</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($settings as $setting)
            <tr>
                <td>{{ $setting->in_start }}</td>
                <td>{{ $setting->in_end }}</td>
                <td>{{ $setting->out_start }}</td>
                <td>{{ $setting->out_end }}</td>
                <td>
                    <a href="{{ route('dashboard.setting.edit', $setting->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('dashboard.setting.destroy', $setting->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('dashboard.setting.create') }}" class="btn btn-success">Add New Setting</a>
</div>
@endsection