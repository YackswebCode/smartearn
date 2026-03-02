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
            <div class="table-responsive">
                <table id="leaderboard-table" class="table table-hover align-middle">
                    <thead class="table-success" style="background-color: #48BB78; color: white;">
                        <tr>
                            <th>Position</th>
                            <th>Affiliate Details</th>
                            <th>Level</th>
                            <th>Icon</th>
                            <th>Sales</th>
                            <th>Total Amount (₦)</th>
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
                            <td>
                                @if($affiliate['level'] == 'Platinum')
                                    <i class="fas fa-gem" style="color: #b0c4de;" title="Platinum"></i>
                                @elseif($affiliate['level'] == 'Gold')
                                    <i class="fas fa-star" style="color: gold;" title="Gold"></i>
                                @elseif($affiliate['level'] == 'Silver')
                                    <i class="fas fa-star" style="color: silver;" title="Silver"></i>
                                @else
                                    <i class="fas fa-star" style="color: #cd7f32;" title="Bronze"></i>
                                @endif
                            </td>
                            <td>{{ $affiliate['sales'] }}</td>
                            <td>₦{{ $affiliate['total_amount'] }}</td>
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
            scrollX: true,
            language: {
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            },
            columnDefs: [
                { orderable: false, targets: [6] } // Disable sorting on Smartearn Award (column index 6)
            ]
        });
    });
</script>
@endpush