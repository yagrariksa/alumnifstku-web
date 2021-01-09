@extends('layouts.codebase')
@section('title')
    Alumni
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/js/plugins/datatables/dataTables.bootstrap4.css')}}">
@endsection
@section('content')
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
                        <th>Nama Lengkap</th>
                        <th class="d-none d-sm-table-cell">Email</th>
                        <th class="d-none d-sm-table-cell">Jurusan</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">Kota Domisili</th>
                        <th class="text-center" style="width: 15%;">Profile</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alumnis as $alumni)
                        <tr>
                            <td class="text-center">{{$loop->iteration}}</td>
                            <td class="font-w600">{{$alumni->biodata->nama}}</td>
                            <td class="d-none d-sm-table-cell">{{$alumni->email}}</td>
                            <td class="d-none d-sm-table-cell">{{$alumni->biodata->jurusan}}</td>
                            <td class="d-none d-sm-table-cell">{{$alumni->biodata->kota_domisili}}</td>
                            <td class="text-center">
                                <a href="{{route('alumni.view', $alumni->id)}}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Lihat Detil">
                                    <i class="fa fa-user"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- END Dynamic Table Full Pagination -->
@endsection
@section('script')
    <script src="{{asset('assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/be_tables_datatables.min.js')}}"></script>
    <script>
        $('.nav-item-sidebar').removeClass('active')
        $('#alumni-index').addClass("active")
    </script>
@endsection