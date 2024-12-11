@extends('admin.layouts.admin.app')
@section('title', 'Manage Payments')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}" />

    <style>
        .th,
        tr {
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title d-flex align-items-center g-2px text-capitalize">
                    <i class="tio-filter-list"></i> Payments List
                    <span class="badge badge-soft-dark ml-2">{{$payments->total()}}</span>
                </h1>
            </div>
        </div>

        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-end align-items-center flex-grow-1">
                            <div class="col-md-4 mb-3 mb-sm-0">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="Search by Name, Amount, TxiD" aria-label="Search"
                                            value="{{ request('search') }}" required>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive datatable-custom">
                        <table
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Transaction ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($payments) > 0)
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $payment->customer->name }}</td>
                                            <td>&dollar; {{ $payment->amount }}</td>
                                            <td>
                                                @if ($payment->payment_status == 'PAID')
                                                <span class="badge badge-success ">Paid</span>
                                                @else
                                                <span class="badge badge-danger">Unpaid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span onclick="copyToClipboard('{{ $payment->transaction_id }}')"
                                                    title="Click to copy"
                                                    style="cursor: pointer;  text-decoration: underline;">
                                                    {{ substr($payment->transaction_id, 0, 5) . '***' . substr($payment->transaction_id, -5) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <div class="pagination-wrapper">
                                            {!! $payments->links() !!}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        @if (count($payments) == 0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-one-cl"
                                    src="/assets/admin/svg/illustrations/sorry.svg"
                                    alt="Image Description">
                                <p class="mb-0">No data to show</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script src="{{ asset('assets/admin/js/global.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('datatableSearch_');
            var searchForm = document.getElementById('searchForm');
            var isSearching = {{ request('search') ? 'true' : 'false' }};

            searchInput.addEventListener('input', function() {
                if (searchInput.value.trim() === '' && isSearching) {
                    window.location.href = "{{ url()->current() }}";
                }
            });

            searchForm.addEventListener('submit', function() {
                searchInput.value = searchInput.value.replace(/-/g, '').trim();
            });
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Transaction ID copied: ' + text);
            }).catch(err => {
                alert('Failed to copy text: ' + err);
            });
        }
    </script>

@endpush
