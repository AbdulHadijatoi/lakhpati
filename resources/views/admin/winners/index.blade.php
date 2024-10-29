@extends('layouts.backend')

@section('css_before')
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/buttons.bootstrap5.min.css') }}">
@endsection

@section('js_after')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-bs5/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
@endsection

@section('content')
<div class="content2 p-4">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Winners <small>Listing</small></h3>
        </div>
        <div class="block-content block-content-full">
            <table class="table responsive table-bordered table-striped table-vcenter fs-sm">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Contest Title</th>
                        <th>Participant ID</th>
                        <th>Winner Rank</th>
                        <th>Prize</th>
                        <th>Date Announced</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($winners as $winner)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $winner->contest->title }}</td>
                        <td>{{ $winner->participant_id }}</td>
                        <td>
                            @if($winner->is_winner)
                                1st Winner
                            @elseif($winner->is_second_winner)
                                2nd Winner
                            @elseif($winner->is_third_winner)
                                3rd Winner
                            @endif
                        </td>
                        <td>
                            @if($winner->is_winner)
                                {{ $winner->contest->winner_prize }}
                            @elseif($winner->is_second_winner)
                                {{ $winner->contest->second_winner_prize }}
                            @elseif($winner->is_third_winner)
                                {{ $winner->contest->third_winner_prize }}
                            @endif
                        </td>
                        <td>{{ $winner->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12 d-flex justify-content-center">{{ $winners->links() }}</div>
        </div>
    </div>
</div>
@endsection
