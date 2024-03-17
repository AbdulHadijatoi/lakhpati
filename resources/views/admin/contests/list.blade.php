@extends('layouts.backend')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/buttons.bootstrap5.min.css') }}">
@endsection

@section('js_after')
    <!-- jQuery (required for DataTables plugin) -->
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/buttons.colVis.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>
@endsection

@section('content')


    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Contests <small>Listing</small>
                </h3>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-vcenter fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">#</th>
                            <th>Winner Prize</th>
                            <th>Runner-up Prize</th>
                            <th>Total Winners</th>
                            <th>Total Runner-ups</th>
                            <th>Participants Limit</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Entry Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contests as $contest)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $contest->winner_prize }}</td>
                            <td>{{ $contest->runner_up_prize }}</td>
                            <td>{{ $contest->contestDetails?$contest->contestDetails->total_winners:'-' }}</td>
                            <td>{{ $contest->contestDetails?$contest->contestDetails->total_runner_ups:'-' }}</td>
                            <td>{{ $contest->contestDetails?$contest->contestDetails->participants_limit:'-' }}</td>
                            <td>{{ $contest->contestDetails?$contest->contestDetails->start_date:'-' }}</td>
                            <td>{{ $contest->contestDetails?$contest->contestDetails->end_date:'-' }}</td>
                            <td>{{ $contest->contestDetails?$contest->contestDetails->entry_fee:'-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $contests->links() }}
            </div>
        </div>
    </div>

@endsection
