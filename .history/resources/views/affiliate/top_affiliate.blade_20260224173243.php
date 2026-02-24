@extends('layouts.affiliate')

@section('title', 'Global Leaderboard')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold">Global Leaderboard</h2>
        <p class="text-muted">Top performing affiliates this month</p>
    </div>

    <!-- Leaderboard Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive"> <!-- Optional wrapper for better mobile handling -->
                <table id="leaderboard-table" class="table table-hover align-middle">
                    <thead class="table-success" style="background-color: #48BB78; color: white;">
                        <tr>
                            <th>Position</th>
                            <th>Affiliate Details</th>
                            <th>Level</th>
                            <th>Sales</th>
                            <th>Total Amount</th>
                            <th>Smartearn Award</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leaderboard as $affiliate)
                        <tr>
                            <td>
                                @if($affiliate['position'] <= 3)
                                    <span class="badge bg-warning text-dark">#{{ $affiliate['position'] }}</span>
                                @else
                                    #{{ $affiliate['position'] }}
                                @endif
                            </td>
                            <td class="fw-bold">{{ $affiliate['name'] }}</td>
                            <td>{{ $affiliate['level'] }}</td>
                            <td>{{ $affiliate['sales'] }}</td>
                            <td>${{ $affiliate['total_amount'] }}</td>
                            <td>{{ $affiliate['award'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#leaderboard-table').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10,
        lengthChange: false,
        autoWidth: false,
        scrollX: true ,// enable horizontal scroll in DataTables
            language: {
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            },
            columnDefs: [
                { orderable: false, targets: [5] } // Disable sorting on Smartearn Award
            ]
        });
    });
</script>
@endpush