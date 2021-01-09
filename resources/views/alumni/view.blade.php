@extends('layouts.codebase')
@section('title')
    {{$alumni->biodata->nama}}
@endsection
@section('style')
    
@endsection
@section('content-top')
<!-- User Info -->
<div class="bg-image bg-image-bottom" style="background-image: url('{{asset('assets/media/photos/photo13@2x.jpg')}}');">
    <div class="bg-primary-dark-op py-30">
        <div class="content content-full text-center">
            <!-- Avatar -->
            <div class="mb-15">
                <a class="img-link" href="be_pages_generic_profile.html">                    
                    @if ($alumni->biodata->foto != null)
                        <img class="img-avatar img-avatar96 img-avatar-thumb" src="{{$alumni->biodata->foto}}" alt="">                        
                    @else
                        <img class="img-avatar img-avatar96 img-avatar-thumb" src="{{asset('assets/media/avatars/avatar15.jpg')}}" alt="">
                    @endif
                </a>
            </div>
            <!-- END Avatar -->

            <!-- Personal -->
            <h1 class="h3 text-white font-w700 mb-10">
                {{$alumni->biodata->nama}}
            </h1>
            <h2 class="h5 text-white-op">
                @if (count($alumni->tracing) > 0)
                    @php
                        $tracing = $alumni->tracing->last();
                    @endphp
                    {{$tracing->jabatan}} <a class="text-primary-light" href="javascript:void(0)">@ {{$tracing->perusahaan}}</a>                    
                @endif
            </h2>
            <span class="text-white-op">{{$alumni->biodata->jurusan}} {{$alumni->biodata->angkatan}}</span>
            <!-- END Personal -->
            
        </div>
    </div>
</div>
<!-- END User Info -->
@section('content')
<h2 class="content-heading">
    <i class="si si-briefcase mr-5"></i> Biodata
</h2>
<div class="row">
    <div class="col-md-6">
        <div class="block">
            <div class="block-header">
                <h3 class="block-title">Alamat</h3>
            </div>
            <div class="block-content">
                <p>{{$alumni->biodata->alamat}}</p>
                <p>Domisili: {{$alumni->biodata->kota_domisili}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <a class="block block-link-shadow text-center" href="mailto:{{$alumni->email}}">
            <div class="block-content">
                <p class="mt-5">
                    <i class="si si-envelope fa-4x text-danger"></i>
                </p>
                <p class="font-w600">Email</p>
            </div>
        </a>
    </div>
    @if ($alumni->biodata->linkedin != null)
        <div class="col-md-3">
            <a class="block block-link-shadow text-center" href="{{$alumni->biodata->linkedin}}">
                <div class="block-content">
                    <p class="mt-5">
                        <i class="si si-globe fa-4x text-primary"></i>
                    </p>
                    <p class="font-w600">Linkedin</p>
                </div>
            </a>
        </div>        
    @endif
</div>

<h2 class="content-heading">
    <i class="si si-briefcase mr-5"></i> Riwayat Pekerjaan
</h2>
<div class="block">    
    <div class="block-content block-content-full">
        <ul class="list list-timeline list-timeline-modern pull-t">
            <!-- Twitter Notification -->
            @foreach ($alumni->tracing as $tracing)
                <li>
                    <div class="list-timeline-time">{{$tracing->tahun_masuk}}</div>
                    <i class="list-timeline-icon si si-briefcase bg-primary"></i>
                    <div class="list-timeline-content">
                        <p class="font-w600">{{$tracing->perusahaan}}</p>
                        <p>{{$tracing->jabatan}} ({{$tracing->cluster}})</p>                        
                    </div>
                </li>                
            @endforeach
            <!-- END Twitter Notification -->
        </ul>
    </div>
</div>
@endsection
@endsection
@section('script')
    
@endsection