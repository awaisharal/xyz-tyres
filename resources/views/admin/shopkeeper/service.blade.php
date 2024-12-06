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
                                <form action="{{url()->current()}}" method="GET">
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                               placeholder="Search by Name, Cnic, Phone" aria-label="Search" value="{{ request('search') }}" required>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive datatable-custom">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light ">
                                <tr>
                                    <th>
                                        #</th>
                                    <th>Image</th>
                                    <th>Shop Name</th>
                                    <th>SP  Name</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($services) > 0)
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td><img src="{{ asset('assets/uploads/services/'. $service->image ) }}" style="width: 50px"  alt=""></td>
                                        <td>{{ $service->user->name }}</td>
                                        <td>{{ $service->serviceProvider->name }}</td>
                                        <td>{{ $service->title }}</td>
                                        <td>{{ $service->description }}</td>
                                        <td>{{ $service->price }}</td>
                                        <td>{{ $service->duration }}</td>
                                        
                                        <td class="d-flex jsutify-content-center">
                                            {{-- <a class="btn btn-white mr-1" href=""><span class="tio-visible"></span></a> --}}
                                            <a class="btn btn-white mr-1" href=""><span class="tio-edit"></span></a>
                                            {{-- <a class="btn btn-white mr-1 form-alert" href="javascript:" data-id=""
                                                data-message="
                                                {{ \App\CPU\translate('Do you want to delete this Booking') }}?
                                                 ">
                                                <span class="tio-delete"></span>
                                            </a> --}}
                                            <form action="" method="post" id="">
                                                @csrf @method('delete')
                                                <button type="submit" class="btn btn-white mr-1">
                                                    <span class="tio-delete"></span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
@endpush
