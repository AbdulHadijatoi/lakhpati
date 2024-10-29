@extends('layouts.backend')

@section('content')
  <div class="content2 p-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('updateContest', $contest->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">Edit Contest</h3>
        </div>
        <div class="block-content block-content-full">
          <div class="row">
              <div class="form-group col-md-6 mb-4">
                  <label class="form-label" for="title">Contest Title <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="title" name="title" value="{{ $contest->title }}" required>
              </div>

              <div class="form-group col-md-6 mb-4">
                <label class="form-label" for="status">Contest Status <span class="text-danger">*</span></label>
                <select class="js-select2 form-select" id="status" name="status" style="width: 100%;" data-placeholder="Select Status">
                  <option value="open" {{ $contest->status == 'open' ? 'selected' : '' }}>Open</option>
                  <option value="closed" {{ $contest->status == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
              </div>

              <div class="form-group col-md-3 mb-4">
                  <label class="form-label" for="winner_prize">Winner Prize <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="winner_prize" name="winner_prize" value="{{ $contest->winner_prize }}" required>
              </div>

              <div class="form-group col-md-3 mb-4">
                  <label class="form-label" for="total_winners">Total Winners <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="total_winners" name="total_winners" value="{{ $contest->contestDetails->total_winners }}" required>
              </div>
              
              <div class="form-group col-md-3 mb-4">
                  <label class="form-label" for="second_winner_prize">2nd Winner Prize <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="second_winner_prize" name="second_winner_prize" value={{ $contest->second_winner_prize }} required>
              </div>

              <div class="form-group col-md-3 mb-4">
                  <label class="form-label" for="total_second_winners">Total 2nd Winners <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="total_second_winners" name="total_second_winners" value="{{ $contest->contestDetails->total_second_winners }}" required>
              </div>
              
              <div class="form-group col-md-3 mb-4">
                  <label class="form-label" for="third_winner_prize">3rd Winner Prize <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="third_winner_prize" name="third_winner_prize" value={{ $contest->third_winner_prize }} required>
              </div>

              <div class="form-group col-md-3 mb-4">
                  <label class="form-label" for="total_third_winners">Total 3rd Winners <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="total_third_winners" name="total_third_winners" value="{{ $contest->contestDetails->total_third_winners }}" required>
              </div>

              <div class="form-group col-md-3 mb-4">
                  <label class="form-label" for="entry_fee">Entry Fee <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="entry_fee" name="entry_fee" value="{{ $contest->contestDetails->entry_fee }}" required>
              </div>

              <div class="form-group col-md-3 mb-4">
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
