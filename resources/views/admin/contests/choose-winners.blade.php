@extends('layouts.backend')

@section('content')
  <div class="content2 p-4">
    <form action="{{ route('updateContest', $contest->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">Choose Winners</h3>
        </div>
        <div class="block-content block-content-full">
          <div class="row">
              <div class="form-group col-md-6 mb-4">
                  <label class="form-label" for="title">Contest Title <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="title" name="title" value="{{ $contest->title }}" required>
              </div>

              
              <div class="form-group col-md-4 mb-4">
                  <label class="form-label" for="entry_fee">Entry Fee <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="entry_fee" name="entry_fee" value="{{ $contest->contestDetails->entry_fee }}" required>
              </div>

              <div class="form-group col-md-4 mb-4">
                  <label class="form-label" for="draw_date">Draw Date</label>
                  <input type="text" class="js-flatpickr form-control" id="draw_date" name="draw_date" value="{{ $contest->draw_date }}" placeholder="Select Draw Date">
              </div>

              <div class="form-group col-12 mb-4">
                <label class="form-label" for="description">Contest Description (OPTIONAL)</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Description..">{{ $contest->description }}</textarea>
              </div>

              <div class="form-group col-12 mb-4">
                <button type="submit" class="btn btn-alt-primary col-12">Update Contest</button>
              </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
