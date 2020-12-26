@extends('layouts.codebase')
@section('title')
    Tambahkan Berita
@endsection
@section('style')
    
@endsection
@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Tambah Berita Baru</h3>
    </div>
    <div class="block">
        <div class="block-content">
            <form class="js-validation-material" action="{{route('news.store')}}" method="post">
                @csrf
                <div class="form-group @error('judul') is-invalid @enderror">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="judul" name="judul" value="{{old('judul')}}">
                        <label for="judul">Judul Berita</label>
                        @error('judul')
                            <div id="judul" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('link') is-invalid @enderror">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="link" name="link" value="{{old('link')}}">
                        <label for="link">URL Berita</label>
                        <div class="form-text text-muted text-left">Pastikan penulisan URL diawali dengan http:// atau https://</div>
                        @error('link')
                            <div id="link" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('gambar') is-invalid @enderror">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="gambar" name="gambar" value="{{old('gambar')}}">
                        <label for="gambar">URL Gambar</label>
                        <div class="form-text text-muted text-left">Pastikan penulisan URL diawali dengan http:// atau https://</div>
                        @error('gambar')
                            <div id="gambar" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group mt-30">
                    <button type="submit" class="btn btn-alt-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    
</div>
@endsection
@section('script')
    <script src="{{asset('assets/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/jquery-validation/additional-methods.js')}}"></script>
    <script src="{{asset('assets/js/pages/be_forms_validation.min.js')}}"></script>
    <script>
        $('.nav-item-sidebar').removeClass('active')
        $('#news-create').addClass("active")
    </script>
@endsection