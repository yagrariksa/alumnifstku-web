@extends('layouts.codebase')

@section('title')
    Log Admin
@endsection
@section('style')

@endsection

@section('content')
    <!-- Page Content -->
    <div class=" bg-white bg-pattern" style="background-image: none;">
        <div class="hero-inner">
            <div class="content content-full">
                <div class="py-15 text-center">
                    <i class="si si-chemistry text-primary display-3"></i>
                    <h1 class="h2 font-w700 mt-15 mb-10">We’ll be back soon!</h1>
                    <h2 class="h3 font-w400 text-muted mb-50">We’re currently for maintenance on this page..</h2>
                    <a class="btn btn-hero btn-noborder btn-rounded btn-alt-primary"
                        href="{{ route('dashboard.index') }}">
                        <i class="fa fa-arrow-left mr-10"></i> Go Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END Page Content -->

    <!-- Page Content -->
    <div class="content">

        <!-- Dynamic Table Full Pagination -->
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Daftar Alumni</h3>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th style="width: 15%;">Nama</th>
                            <th class="d-none d-sm-table-cell">LOG</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 15%;">DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="font-w600">{{ $admin->name }}</td>
                                <td class="d-none d-sm-table-cell">{{ $admin->email }}</td>
                                <td class="d-none d-sm-table-cell text-center">{{ $admin->role }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Dynamic Table Full Pagination -->


    </div>
    <!-- END Page Content -->
@endsection

@section('script')
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
@endsection
