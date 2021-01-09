@extends('layouts.codebase')
@section('title')
    FST News
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
            <h3 class="block-title">Daftar Berita FST News</h3>
        </div>
        <div class="block-content block-content-full">
            @foreach ($news as $n)
                <div class="mb-50">
                    <div class="overflow-hidden rounded mb-20" style="height: 300px;">
                        <a class="img-link" href="{{$n->link}}">
                            <img class="img-fluid" src="{{$n->gambar}}" alt="">
                        </a>
                    </div>
                    <h3 class="h4 font-w700 text-uppercase mb-5">{{$n->judul}}</h3>                    
                    <div class="text-muted mb-10">
                        <span class="mr-15">
                            <i class="fa fa-fw fa-calendar mr-5"></i>{{Carbon\Carbon::parse($n->created_at)->diffForHumans()}}
                        </span>
                        <a class="text-muted mr-15" href="javascript:void(0)">
                            <i class="fa fa-fw fa-user mr-5"></i>{{Auth::user()->name}}
                        </a>                        
                        <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{route('news.edit', $n->id)}}">
                            <i class="fa fa-pencil mr-5"></i> Edit Berita
                        </a>
                        <a class="link-effect text-muted mr-10 mb-5 delete-text d-inline-block" href="{{route('news.destroy', $n->id)}}">
                            <i class="fa fa-trash-o mr-5"></i> Hapus Berita
                        </a>
                    </div>                    
                </div>                
            @endforeach

        </div>
    </div>
    <nav class="clearfix push">
        <a class="btn btn-secondary min-width-100 float-right @if(!$news->nextPageUrl()) disabled @endif" href="@if(!$news->nextPageUrl()) javascript:void(0) @else {{$news->nextPageUrl()}} @endif">
            Next <i class="fa fa-arrow-right ml-5"></i>
        </a>
        <a class="btn btn-secondary min-width-100 float-left @if(!$news->previousPageUrl()) disabled @endif" href="@if(!$news->previousPageUrl()) javascript:void(0) @else {{$news->previousPageUrl()}} @endif">
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
        $('#news-index').addClass("active")
    </script>
@endsection