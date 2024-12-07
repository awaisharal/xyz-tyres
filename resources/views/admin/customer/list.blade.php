@extends('admin.layouts.admin.app')
@section('title', 'Manage Customers')

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
                <i class="tio-filter-list"></i> Customers List 
                <span class="badge badge-soft-dark ml-2">{{$customers->total()}}</span>
            </h1>
        </div>
    </div>

    <div class="row gx-2 gx-lg-3">
        <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-end align-items-center flex-grow-1">
                        <div class="col-md-4 mb-3 mb-sm-0">
                            <form action="{{ url()->current() }}" method="GET" id="searchForm">
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="Search by Name, Email" aria-label="Search"
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($customers) > 0)
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></td>

                                        <td class="d-flex justify-content-center">
                                            <button class="btn btn-white mr-1" onClick="updateCustomer('{{ $customer->name }}','{{ $customer->email }}','{{ $customer->id }}')">
                                                <span class="tio-edit"></span>
                                            </button>

                                            <button type="button" onClick="deleteCustomer({{ $customer->id }})" class="btn btn-white mr-1">
                                                <span class="tio-delete"></span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif   
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <div class="pagination-wrapper">
                                        {!! $customers->links() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    @if (count($customers) == 0)
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


 <!-- Modal Area Start Here -->
 <div class="modal fade" id="updateCustomer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1 text-start">Update Customer</h3>
                    <hr>
                </div>
                <form class="row d-block" method="POST"
                    action="{{ route('admin.customer.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group lang_form">
                                <label class="input-label">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Eg. Name" required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group lang_form">
                                <label class="input-label">Customer Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="example@example.com" readonly disabled>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" name="id" id="id">
                    <div class="col-12 d-flex justify-content-end ">
                        <button type="submit"
                            class="btn btn-primary me-sm-3 me-1">Update</button>
                        <button type="reset" class="btn btn-outline-secondary ml-2"
                            data-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteCustomer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-simple modal-enable-otp">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body p-md-0">
                <div class="text-center mb-4">
                    <h3 class="mb-2 pb-1 text-start">Are you sure?</h3>
                    <hr>
                </div>
                <form class="row d-block" method="POST" action="{{ route('admin.customer.delete') }}">
                    @csrf
                    <div>
                        <p class="mt-2">This action is permanent and cannot be undone. The customer will be deleted from the system.</p>
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
<script src={{asset("public/assets/admin/js/global.js")}}></script>
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


    function updateCustomer(name, email, id) {
        $("#updateCustomer #name").val(name);
        $("#updateCustomer #email").val(email);
        $("#updateCustomer #id").val(id);
        $("#updateCustomer").modal('show');
    }

    function deleteCustomer(id) {
        $("#deleteCustomer #id").val(id);
        $("#deleteCustomer").modal('show');
    }
</script>
@endpush
