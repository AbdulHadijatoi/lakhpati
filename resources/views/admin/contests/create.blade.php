@extends('layouts.backend')

@section('content')
  <div class="content">
    <form action="{{ route('contestStore') }}" method="POST">
      @csrf
      <div class="block block-rounded">
        <div class="block-header block-header-default">
          <h3 class="block-title">Create contest</h3>
        </div>
        <div class="block-content block-content-full">
          <div class="row">
            <div class="col-12">  

              <div class="form-group mb-4">
                  <label class="form-label" for="winner_prize">Winner Prize <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="winner_prize" name="winner_prize" required>
              </div>

              <div class="form-group mb-4">
                  <label class="form-label" for="runner_up_prize">Runner-up Prize <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="runner_up_prize" name="runner_up_prize" required>
              </div>

              <div class="form-group mb-4">
                  <label class="form-label" for="total_winners">Total Winners <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="total_winners" name="total_winners" required>
              </div>

              <div class="form-group mb-4">
                  <label class="form-label" for="total_runner_ups">Total Runner-ups <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="total_runner_ups" name="total_runner_ups" required>
              </div>

              <div class="form-group mb-4">
                  <label class="form-label" for="participants_limit">Participants Limit <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="participants_limit" name="participants_limit" required>
              </div>

              <div class="form-group mb-4">
                  <label class="form-label" for="start_date">Start Date <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="start_date" name="start_date" required>
              </div>

              <div class="form-group mb-4">
                  <label class="form-label" for="end_date">End Date <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="end_date" name="end_date" required>
              </div>

              <div class="form-group mb-4">
                  <label class="form-label" for="entry_fee">Entry Fee <span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="entry_fee" name="entry_fee" required>
              </div>

              <button type="submit" class="btn btn-alt-primary col-12">Create Contest</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

   