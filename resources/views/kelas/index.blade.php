@extends('layouts.codebase')
@section('title')
    Kelas Alumni
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/js/plugins/datatables/dataTables.bootstrap4.css')}}">
    <style>
        a.delete-text::before {
            background-color: #e74c3c!important;
        }
    </style>
@endsection
@section('content')
    <!-- Dynamic Table Full Pagination -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Daftar Kelas Alumni</h3>
        </div>
        <div class="block-content block-content-full">
            @foreach ($kelas as $n)
                <div class="mb-50">
                    {{-- <div class="overflow-hidden rounded mb-20" style="height: 300px;">
                        <a class="img-link" href="{{$n->link}}">
                            <img class="img-fluid" src="{{$n->gambar}}" alt="">
                        </a>
                    </div> --}}
                    <h3 class="h4 font-w700 text-uppercase mb-5">{{$n->judul}}</h3>
                    <p class="font-w500 mb-5">Kuota : {{$n->kuota}}<br>Kategori : {{$n->kategori}}<br>Tanggal : {{$n->tanggal}} <br> <a href="{{route('kelas.pembicara.index',$n->id)}}">Lihat Pembicara</a> </p>                    
                    <div class="text-muted mb-10">
                        <span class="mr-15">
                            <i class="fa fa-fw fa-calendar mr-5"></i>{{Carbon\Carbon::parse($n->created_at)->diffForHumans()}}
                        </span>
                        <a class="text-muted mr-15" href="javascript:void(0)">
                            <i class="fa fa-fw fa-user mr-5"></i>{{Auth::user()->name}}
                        </a>                        
                        <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{route('kelas.edit', $n->id)}}">
                            <i class="fa fa-pencil mr-5"></i> Edit Kelas      
                        </a>
                        <a class="link-effect text-muted mr-10 mb-5 delete-text d-inline-block" href="{{route('kelas.destroy', $n->id)}}">
                            <i class="fa fa-trash-o mr-5"></i> Hapus Kelas      
                        </a>
                    </div>                    
                </div>                
            @endforeach

        </div>
    </div>
    <nav class="clearfix push">
        <a class="btn btn-secondary min-width-100 float-right @if(!$kelas->nextPageUrl()) disabled @endif" href="@if(!$kelas->nextPageUrl()) javascript:void(0) @else {{$kelas->nextPageUrl()}} @endif">
            Next <i class="fa fa-arrow-right ml-5"></i>
        </a>
        <a class="btn btn-secondary min-width-100 float-left @if(!$kelas->previousPageUrl()) disabled @endif" href="@if(!$kelas->previousPageUrl()) javascript:void(0) @else {{$loker->previousPageUrl()}} @endif">
            <i class="fa fa-arrow-left mr-5"></i> Prev
        </a>
    </nav>
    <!-- END Dynamic Table Full Pagination -->
@endsection
@section('script')
    <script src="{{asset('assets/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/be_tables_datatables.min.js')}}"></script>
    <script>
        $('.nav-item-sidebar').removeClass('active')
        $('#kelas-index').addClass("active")
    </script>
@endsection