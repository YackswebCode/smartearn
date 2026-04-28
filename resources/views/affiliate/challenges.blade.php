@extends('layouts.affiliate')

@section('title', 'Affiliate Challenges')

@section('content')
<div class="container-fluid py-4">
    <!-- Header & Filter -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Affiliate Challenges</h2>
            <p class="text-muted">Active and concluded challenges from creators</p>
        </div>

        {{-- Filter: Active / Concluded --}}
        <form method="GET" action="{{ route('affiliate.challenges') }}" class="d-flex align-items-center gap-2">
            <select name="status" class="form-select" style="width: 180px;" onchange="this.form.submit()">
                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active Challenges</option>
                <option value="concluded" {{ $status == 'concluded' ? 'selected' : '' }}>Concluded Challenges</option>
                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All Challenges</option>
            </select>
        </form>
    </div>

    <!-- Challenges Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="challenges-table" class="table table-hover align-middle">
                    <thead class="table-success" style="background-color: #48BB78; color: white;">
                        <tr>
                            <th>Product Name</th>
                            <th>Commission</th>
                            <th>Vendor</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($challenges as $challenge)
                        <tr>
                            <td class="fw-bold">{{ $challenge->product_name }}</td>
                            <td>{{ $challenge->commission }}%</td>
                            <td>{{ $challenge->vendor_name }}</td>
                            <td>
                                @if($challenge->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($challenge->status == 'concluded')
                                    <span class="badge bg-secondary">Concluded</span>
                                @else
                                    <span class="badge bg-light text-dark">All</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary view-details"
                                        data-name="{{ $challenge->product_name }}"
                                        data-start="{{ $challenge->start_date }}"
                                        data-end="{{ $challenge->end_date }}"
                                        data-instructions="{{ $challenge->instructions }}"
                                        data-prizes="{{ $challenge->prizes }}">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Challenge Details Modal -->
<div class="modal fade" id="challengeModal" tabindex="-1" aria-labelledby="challengeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="challengeModalLabel">
                    <i class="fas fa-trophy me-2"></i>Challenge Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 id="modal-product-name" class="fw-bold mb-3"></h4>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong><i class="far fa-calendar-alt me-1"></i> Start Date</strong>
                        <p id="modal-start-date" class="mb-0"></p>
                    </div>
                    <div class="col-md-6">
                        <strong><i class="far fa-calendar-check me-1"></i> End Date</strong>
                        <p id="modal-end-date" class="mb-0"></p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-info-circle me-1"></i> Instructions</strong>
                    <p id="modal-instructions" class="mt-1"></p>
                </div>

                <div class="mb-2">
                    <strong><i class="fas fa-gift me-1"></i> Prizes</strong>
                    <p id="modal-prizes" class="mt-1"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#challenges-table').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            pageLength: 10,
            lengthChange: false,
            autoWidth: false,
            language: {
                paginate: { previous: "Previous", next: "Next" }
            }
        });

        // View Details modal
        $('.view-details').on('click', function() {
            const btn = $(this);
            $('#modal-product-name').text(btn.data('name'));
            $('#modal-start-date').text(btn.data('start'));
            $('#modal-end-date').text(btn.data('end'));
            $('#modal-instructions').text(btn.data('instructions'));
            $('#modal-prizes').text(btn.data('prizes'));
            $('#challengeModal').modal('show');
        });
    });
</script>
@endpush