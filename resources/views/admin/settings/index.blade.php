@extends('layouts.backend')

@section('content')
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Settings</h3>
            <a href="{{ route('settings.create') }}" class="btn btn-primary">Add New Setting</a>
        </div>
        <div class="block-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <td>{{ $setting->key }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>
                                <a href="{{ route('settings.edit', $setting->key) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('settings.destroy', $setting->key) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this setting?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
