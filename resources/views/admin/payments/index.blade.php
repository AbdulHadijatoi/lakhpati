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


    <div class="content2 p-4">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Easypaisa Payments <small>History</small>
                </h3>
                
            </div>
            <div class="block-content block-content-full">
                <table class="table responsive table-bordered table-striped table-vcenter fs-sm">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">#</th>
                            <th>User</th>
                            <th>Contest</th>
                            <th>Amount</th>
                            <th>Payment status</th>
                            <th>Description</th>
                            <th>Order reference</th>
                            <th>Created at</th>
                            <th>Refund status</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $payment->user? $payment->user->name: '-' }}</td>
                            <td>{{ $payment->contest? $payment->contest->title: '-' }}</td>
                            <td>{{ $payment->amount }}</td>
                           
                            <td>
                                @if($payment->payment_status)
                                    @if($payment->payment_status == "completed")
                                        <span class="btn small btn-success">
                                    @elseif($payment->payment_status == "pending")
                                        <span class="btn small btn-info">
                                    @else
                                        <span class="btn btn-error">
                                    @endif
                                    {{ $payment->payment_status ?? '-' }} </span>
                                @endif
                            </td>
                            <td>{{ $payment->description }}</td>
                            <td>{{ $payment->order_reference }}</td>
                            <td>{{ $payment->created_at }}</td>
                            <td>
                                @if($payment->refund_status)
                                    @if($payment->refund_status == "approved")
                                        <span class="btn small btn-success">
                                    @elseif($payment->refund_status == "pending")
                                        <span class="btn small btn-info">
                                    @else
                                        <span class="btn btn-error">
                                    @endif
                                    {{ $payment->refund_status ?? '-' }} </span>
                                @endif
                            </td>
                            {{-- <td>
                                <a href="{{ route('editContest', $contest->id) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Edit"><i class="fa fa-pen"></i></a>
                                <a href="{{ route('showContest', $contest->id) }}" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="View"><i class="fa fa-eye"></i></a>
                                <form action="{{ route('deleteContest', $contest->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this contest?')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Delete"><i class="fa fa-trash"></i></button>
                                </form>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12 d-flex justify-content-center">{{ $payments->links() }}</div>
            </div>
        </div>
    </div>

@endsection
