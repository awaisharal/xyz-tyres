@extends('admin.layouts.admin.app')
@section('title', 'Manage Shops')

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}" />

    <style>
        .th, tr {
            text-align: center;
        }

    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="row align-items-center mb-3">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title d-flex align-items-center g-2px text-capitalize">
                    <i class="tio-filter-list"></i> Shopkeepers List
                    <span class="badge badge-soft-dark ml-2">{{$shopkeepers->total()}}</span>
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
                                               placeholder="Search by Shop Name, Email, Company" aria-label="Search" value="{{ request('search') }}" required>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive datatable-custom">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Shop Name</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Payments allowed</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($shopkeepers) > 0)
                                @foreach ($shopkeepers as $shopkeeper)
                                    <tr>
                                        <td>{{ $shopkeeper->id }}</td>
                                        <td>{{ $shopkeeper->name }}</td>
                                        <td><a href="mailto:{{ $shopkeeper->email }}">{{ $shopkeeper->email }}</a></td>
                                        <td>{{ $shopkeeper->company }}</td>

                                        <!-- Toggle Button for is_permitted -->
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" class="is-permitted-toggle" data-shopkeeper-id="{{ $shopkeeper->id }}" {{ $shopkeeper->is_permitted ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td class="d-flex justify-content-center">
                                            <a class="btn btn-white mr-1" onclick="updateShopkeeper('{{ $shopkeeper->name }}','{{ $shopkeeper->email }}','{{ $shopkeeper->company }}','{{ $shopkeeper->id }}')"  href="javascript:void(0)">
                                                <span class="tio-edit"></span>
                                            </a>
                                            <button type="button" onClick="deleteShopkeeper({{ $shopkeeper->id }})" class="btn btn-white mr-1">
                                                <span class="tio-delete"></span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6">
                                        <div class="pagination-wrapper">
                                            {!! $shopkeepers->links() !!}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        @if (count($shopkeepers) == 0)
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

{{-- Modal Area Starts Here --}}
<div class="modal fade" id="updateShopkeeper" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1 text-start">Update Shopkeeper</h3>
                    <hr>
                </div>
                <form class="row d-block" method="POST" action="{{{ route('admin.shopkeeper.update')}}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group lang_form" >
                                <label class="input-label">Shopkeeper Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name " required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group lang_form" >
                                <label class="input-label">Shopkeeper Email <span class="text-danger">*</span></label>
                                <input type="text" id="email"  class="form-control" placeholder="Enter Email" disabled readonly>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group lang_form" >
                                <label class="input-label">Company Name <span class="text-danger">*</span></label>
                                <input type="text" name="company" id="company"  class="form-control" placeholder="Enter Email" >
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end ">
                        <input type="hidden" id="id" name="id">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                        <button type="reset" class="btn btn-outline-secondary ml-2" data-dismiss="modal" aria-label="Close"> Cancel </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteShopkeeper" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1 text-start">Are you sure?</h3>
                    <hr>
                </div>
                <form class="row d-block" method="POST" action="{{ route('admin.shopkeeper.delete') }}">
                    @csrf
                    <div>
                        <p class="mt-2">This action is permanent and cannot be undone. This shop will be deleted from the system.</p>
                    </div>

                    <div class="col-12 d-flex justify-content-end ">
                        <input type="hidden" class="form-control" name="id" id="id">
                        <button type="submit" class="btn btn-primary me-sm-3">Delete</button>
                        <button type="reset" class="btn btn-outline-secondary mx-2" data-dismiss="modal" aria-label="Close"> Cancel </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
<script src="{{ asset('assets/admin/js/global.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('datatableSearch_');
        var searchForm = document.getElementById('searchForm');
        var isSearching = {{ request('search') ? 'true' : 'false' }};

        searchInput.addEventListener('input', function () {
            if (searchInput.value === '' && isSearching) {
                window.location.href = "{{ url()->current() }}";
            }
        });
        searchForm.addEventListener('submit', function () {
            searchInput.value = searchInput.value.replace(/-/g, '');
            isSearching = true;
        });
    });

    function updateShopkeeper(name, email,company,id)
    {
        $("#updateShopkeeper #name").val(name);
        $("#updateShopkeeper #email").val(email);
        $("#updateShopkeeper #company").val(company);
        $("#updateShopkeeper #id").val(id);
        $("#updateShopkeeper").modal('show');
    }

    function deleteShopkeeper(id) {
        $("#deleteShopkeeper #id").val(id);
        $("#deleteShopkeeper").modal('show');
    }


    //toggle button
    $(document).ready(function() {
    // Listen for toggle button change
    $('.is-permitted-toggle').change(function() {
        var shopkeeperId = $(this).data('shopkeeper-id');
        var isPermitted = $(this).prop('checked') ? 1 : 0;

        // Send AJAX request to update the 'is_permitted' status
        $.ajax({
            url: '/admin/shopkeeper/toggle-permission', // Define the correct route
            method: 'POST',
            data: {
                shopkeeper_id: shopkeeperId,
                is_permitted: isPermitted,
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
                if (response.success) {
                    // Optionally, update the toggle color or add a success class
                    // You can also update the status text next to the toggle button if needed
                    // Example: changing the toggle to green on success
                    $('.is-permitted-toggle[data-shopkeeper-id="'+shopkeeperId+'"]').parent().toggleClass('success');
                }
            },
            error: function() {
                // Revert the toggle if the update fails
                $('.is-permitted-toggle[data-shopkeeper-id="'+shopkeeperId+'"]').prop('checked', !isPermitted);
            }
            });
        });
    });



</script>
@endpush
