@extends('layouts.vendor')

@section('title', 'Orders & Sales')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Orders & Sales</h2>
    </div>

    {{-- Overall Sales Summary --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Overall Sales</h6>
                        <span class="badge bg-success">{{ $totalSalesChange }}</span>
                    </div>
                    <h3 class="fw-bold">
                        {{ ($symbols[$userCurrency] ?? '') . number_format($totalVolumeUserCurrency, 2) }}
                    </h3>
                    <small class="text-muted">Total sales volume in your currency</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Number of Sales</h6>
                        <span class="badge bg-success">{{ $salesChange }}</span>
                    </div>
                    <h3 class="fw-bold">{{ number_format($salesCount) }}</h3>
                    <small class="text-muted">Completed transactions</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Earnings</h6>
                        <span class="badge bg-success">{{ $earningsChange }}</span>
                    </div>
                    <h3 class="fw-bold">
                        {{ ($symbols[$userCurrency] ?? '') . number_format($totalEarningsUserCurrency, 2) }}
                    </h3>
                    <small class="text-muted">Affiliate commission earned</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Currency Breakdown --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Volume (NGN)</h6>
                        <span class="badge bg-success">{{ $volumeChange }}</span>
                    </div>
                    <h3 class="fw-bold">₦{{ number_format($volumeNGN, 2) }}</h3>
                    <small class="text-muted">Sales made in Nigeria</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Volume (USD)</h6>
                        <span class="badge bg-success">{{ $volumeChange }}</span>
                    </div>
                    <h3 class="fw-bold">${{ number_format($volumeUSD, 2) }}</h3>
                    <small class="text-muted">Sales made in the United States</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Volume (GHS)</h6>
                        <span class="badge bg-success">{{ $volumeChange }}</span>
                    </div>
                    <h3 class="fw-bold">GH¢{{ number_format($volumeGHS, 2) }}</h3>
                    <small class="text-muted">Sales made in Ghana</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Volume (XAF)</h6>
                        <span class="badge bg-success">{{ $volumeChange }}</span>
                    </div>
                    <h3 class="fw-bold">FCFA{{ number_format($volumeXAF, 2) }}</h3>
                    <small class="text-muted">Sales made in CFA region</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Total Volume (KES)</h6>
                        <span class="badge bg-success">{{ $volumeChange }}</span>
                    </div>
                    <h3 class="fw-bold">KES{{ number_format($volumeKES, 2) }}</h3>
                    <small class="text-muted">Sales made in Kenya</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-muted mb-0">Withdrawn</h6>
                        <span class="badge bg-success">{{ $withdrawalChange }}</span>
                    </div>
                    <h3 class="fw-bold">
                        {{ ($symbols[$userCurrency] ?? '') . number_format($totalWithdrawnUserCurrency, 2) }}
                    </h3>
                    <small class="text-muted">Funds already withdrawn</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold">Recent Transactions</h5>
                <small class="text-muted">Latest completed orders</small>
            </div>
            <small class="text-muted">Click “Details” to view transaction info</small>
        </div>

        <div class="card-body p-3">
            <table id="ordersTable" class="table table-hover align-middle nowrap" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>Product Type</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Transaction Ref</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Affiliate Name</th>
                        <th>Affiliate Email</th>
                        <th>Commission</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordersList as $order)
                        <tr>
                            <td>{{ $order->product_type }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_email }}</td>
                            <td>{{ $order->reference }}</td>
                            <td>{{ $order->date }}</td>
                            <td>{{ $order->amount_formatted }}</td>
                            <td>{{ $order->affiliate_name }}</td>
                            <td>{{ $order->affiliate_email }}</td>
                            <td>{{ $order->commission_formatted }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary view-order-btn"
                                    data-order='@json($order)'
                                    data-bs-toggle="modal"
                                    data-bs-target="#orderDetailsModal">
                                    Details
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

{{-- Details Modal --}}
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="orderDetailsModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Product Name</small>
                            <strong id="modalProductName">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Product Type</small>
                            <strong id="modalProductType">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Customer Name</small>
                            <strong id="modalCustomerName">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Customer Email</small>
                            <strong id="modalCustomerEmail">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Transaction Reference</small>
                            <strong id="modalReference">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Date</small>
                            <strong id="modalDate">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Amount</small>
                            <strong id="modalAmount">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Commission</small>
                            <strong id="modalCommission">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Affiliate Name</small>
                            <strong id="modalAffiliateName">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Affiliate Email</small>
                            <strong id="modalAffiliateEmail">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Currency</small>
                            <strong id="modalCurrency">-</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted d-block">Status</small>
                            <strong id="modalStatus">-</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable('#ordersTable', {
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            pageLength: 10,
            lengthChange: false,
            autoWidth: false,
            scrollX: true,
            language: {
                search: "Search:",
                emptyTable: "No orders found"
            }
        });

        const buttons = document.querySelectorAll('.view-order-btn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const order = JSON.parse(this.dataset.order);

                document.getElementById('modalProductName').textContent = order.product_name ?? '-';
                document.getElementById('modalProductType').textContent = order.product_type ?? '-';
                document.getElementById('modalCustomerName').textContent = order.customer_name ?? '-';
                document.getElementById('modalCustomerEmail').textContent = order.customer_email ?? '-';
                document.getElementById('modalReference').textContent = order.reference ?? '-';
                document.getElementById('modalDate').textContent = order.date ?? '-';
                document.getElementById('modalAmount').textContent = order.amount_formatted ?? '-';
                document.getElementById('modalCommission').textContent = order.commission_formatted ?? '-';
                document.getElementById('modalAffiliateName').textContent = order.affiliate_name ?? '-';
                document.getElementById('modalAffiliateEmail').textContent = order.affiliate_email ?? '-';
                document.getElementById('modalCurrency').textContent = order.currency ?? '-';
                document.getElementById('modalStatus').textContent = order.status ?? '-';
            });
        });
    });
</script>
@endpush