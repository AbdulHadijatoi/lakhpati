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
                    Refund <small>Users</small>
                </h3>
                    <!-- Button to Open Modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchRefundModal">
                    Search by phone and refund
                </button>
            </div>
            <div class="block-content block-content-full">
                <table class="table responsive table-bordered table-striped table-vcenter fs-sm">
                    <thead>
                        <tr>
                            <th>Refund Id</th>
                            <th>User Name</th>
                            <th>Total Contests</th>
                            <th>Total Participations</th>
                            <th>Total Refund Amount</th>
                            <th>Refund Date</th>
                            <th>Refund status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($refunds as $refund)
                            <tr>
                                <td>{{ $refund->id }}</td>
                                <td>{{ $refund->user->name }}</td>
                                <td>{{ $refund->total_contests }}</td>
                                <td>{{ $refund->total_participations }}</td>
                                <td>{{ $refund->total_refund_amount }}</td>
                                <td>{{ $refund->refund_date }}</td>
                                <td>
                                @if($refund->refund_status)
                                    @if($refund->refund_status == "approved")
                                            <span class="btn small btn-success">
                                        @elseif($refund->refund_status == "pending")
                                            <span class="btn small btn-info">
                                        @else
                                            <span class="btn btn-error">
                                        @endif
                                        {{ ucfirst($refund->refund_status) }} </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12 d-flex justify-content-center">{{ $refunds->links() }}</div>
            </div>
        </div>
    </div>

<!-- Bootstrap Modal for User Search -->
<div class="modal fade" id="searchRefundModal" tabindex="-1" aria-labelledby="searchRefundLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="searchRefundLabel">Search User by Phone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="searchUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter user phone">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="searchUser()">Search</button>
                </form>
                
                <!-- Display search results here -->
                <div id="userSearchResult" class="mt-4"></div>
            </div>
        </div>
    </div>
</div>

<script>
function searchUser() {
    let phone = $('#phone').val();
    $.ajax({
        url: "{{ route('refund.searchUser') }}",
        method: "POST",
        data: { phone: phone, _token: "{{ csrf_token() }}" },
        success: function(response) {
            let eligibilityBadge = response.eligibleForRefund 
                ? `<span class="badge bg-success">Eligible</span>` 
                : `<span class="badge bg-danger">Not Eligible</span>`;

            let resultHtml = `
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">${response.user.name}</h5>
                        <p class="card-text"><strong>Phone:</strong> ${response.user.phone}</p>
                        <p><strong>Total Participations:</strong> ${response.totalParticipations}</p>
                        <p><strong>Total Contests:</strong> ${response.totalContests}</p>
                        <p><strong>Total Refund Amount:</strong> Rs. ${response.totalRefundAmount}</p>
                        <p><strong>Refund Eligibility:</strong> ${eligibilityBadge}</p>
                    </div>
                </div>`;

            if (response.eligibleForRefund) {
                resultHtml += `
                    <div class="mt-3 text-center">
                        <form action="{{ route('refund.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="${response.user.id}">
                            <button type="submit" class="btn btn-success">Approve Refund</button>
                        </form>
                    </div>`;
            } else {
                resultHtml += `
                    <div class="mt-3">
                        <p class="text-muted">User needs at least ${response.minParticipationLimit} participations to be eligible for a refund.</p>
                    </div>`;
            }

            $('#userSearchResult').html(resultHtml);
        },
        error: function() {
            $('#userSearchResult').html('<p class="text-danger">User not found or an error occurred.</p>');
        }
    });
}


</script>

@endsection
