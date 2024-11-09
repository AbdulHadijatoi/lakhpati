@extends('layouts.backend')

@section('content')
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Add Setting</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('settings.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="key" class="form-label">Key</label>
                    <input type="text" class="form-control" id="key" name="key" required>
                </div>
                <div class="mb-3">
                    <label for="value" class="form-label">Value</label>
                    <textarea class="form-control" id="value" name="value" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
