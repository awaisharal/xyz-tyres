@extends('admin.layouts.admin.app')
@section('title', 'Manage Payments')

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
                    <i class="tio-filter-list"></i>
                    Shopkeepers List
                    {{-- {{ \App\CPU\translate('Payment_list') }} --}}
                    <span class="badge badge-soft-dark ml-2"></span>
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
                                    <th>
                                        #</th>
                                    <th>Shop Name</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            {{-- @if (count($payments) > 0) --}}
                                @foreach ($shopkeepers as $shopkeeper)
                                    <tr>
                                        <td>{{ $shopkeeper->id }}</td>
                                        <td>{{ $shopkeeper->name }}</td>
                                        <td>{{ $shopkeeper->email }}</td>
                                        <td>{{ $shopkeeper->company }}</td>
                                        
                                        <td class="d-flex justify-content-center">
                                            {{-- <a class="btn btn-white mr-1" href=""><span class="tio-visible"></span></a> --}}
                                            <a class="btn btn-white mr-1" onclick="updateShopkeeper('{{$shopkeeper->name }}','{{$shopkeeper->email}}','{{$shopkeeper->company}}','{{$shopkeeper->id}}')"  href="javascript:void(0)"><span class="tio-edit"></span></a>
                                            {{-- <a class="btn btn-white mr-1 form-alert" href="javascript:" data-id=""
                                                data-message="
                                                {{ \App\CPU\translate('Do you want to delete this Booking') }}?
                                                 ">
                                                <span class="tio-delete"></span>
                                            </a> --}}
                                            <form action="{{ route('admin.shopkeeper.destroy', $shopkeeper->id ) }}" method="post" id="delete-form-{{ $shopkeeper->id }}">
                                                @csrf @method('delete')
                                                <button type="button" onclick="confirmDelete({{ $shopkeeper->id }})" class="btn btn-white mr-1">
                                                    <span class="tio-delete"></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- Modal -->
                                <div class="modal fade" id="updateShopkeeper" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-simple modal-enable-otp modal-dialog-centered">
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
                                                        <label class="input-label">Shopkeeper Name<span
                                                            class="input-label-secondary text-danger">*</span></label>
                                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter name " required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group lang_form" >
                                                        <label class="input-label">Shopkeeper Email</label>
                                                        <input type="text" name="email" id="email"  class="form-control" placeholder="Enter Email" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group lang_form" >
                                                        <label class="input-label">Company Name</label>
                                                        <input type="text" name="company" id="company"  class="form-control" placeholder="Enter Email" >
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control" name="id" id="id">
                                            <div class="col-12 d-flex justify-content-end ">
                                              <button type="submit" class="btn btn-primary me-sm-3 me-1">Update</button>
                                              <button
                                                type="reset"
                                                class="btn btn-outline-secondary ml-2"
                                                data-dismiss="modal"
                                                aria-label="Close">
                                                Cancel
                                              </button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            {{-- @endif --}}
                            </tbody>
                            <tfoot>
                                <tr >
                                    <td colspan="5">
                                        <div class="pagination-wrapper">
                                            {{-- {!! $payments->links() !!} --}}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        {{-- @if (count($payments) == 0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-one-cl"
                                    src="{{ asset('public/assets/admin/svg/illustrations/sorry.svg') }}"
                                    alt="{{ \App\CPU\translate('Image Description') }}">
                                <p class="mb-0">{{ \App\CPU\translate('No_data_to_show') }}</p>
                            </div>
                        @endif --}}
                    </div>
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
    </script>
     <script>
        function confirmDelete(shopkeeperId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + shopkeeperId).submit();
                }
            });
        }
    </script>
    <script>
        
        function updateShopkeeper(name, email,company,id)
        {
            $("#updateShopkeeper #name").val(name);
            $("#updateShopkeeper #email").val(email);
            $("#updateShopkeeper #company").val(company);
            $("#updateShopkeeper #id").val(id);
            $("#updateShopkeeper").modal('show');
        }
        
    </script>
@endpush