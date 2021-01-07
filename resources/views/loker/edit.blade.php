@extends('layouts.codebase')
@section('title')
    Tambahkan Loker
@endsection
@section('style')
    
@endsection
@section('content')
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Tambah Loker Baru</h3>
    </div>
    <div class="block">
        <div class="block-content">
            <form class="js-validation-material" action="{{route('loker.update', $loker->id)}}" method="post">
                @csrf
                <div class="form-group @error('jabatan') is-invalid @enderror">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{old('jabatan') == null ? $loker->jabatan : old('jabatan')}}">
                        <label for="jabatan">Jabatan Lowongan</label>
                        @error('jabatan')
                            <div id="jabatan" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('perusahaan') is-invalid @enderror">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="perusahaan" name="perusahaan" value="{{old('perusahaan') == null ? $loker->perusahaan : old('perusahaan')}}">
                        <label for="perusahaan">Perusahaan Lowongan</label>
                        @error('perusahaan')
                            <div id="perusahaan" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('deskripsi') is-invalid @enderror">
                    <div class="form-material floating">
                        <textarea rows="4" type="text" class="form-control" id="deskripsi" name="deskripsi" >{{old('deskripsi')  == null ? $loker->deskripsi : old('deskripsi')}}</textarea>
                        <label for="deskripsi">Deskripsi Lowongan</label>
                        @error('deskripsi')
                            <div id="deskripsi" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('link') is-invalid @enderror">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="link" name="link" value="{{old('link')  == null ? $loker->link : old('link')}}">
                        <label for="link">URL Loker</label>
                        <div class="form-text text-muted text-left">Pastikan penulisan URL diawali dengan http:// atau https://</div>
                        @error('link')
                            <div id="link" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('poster') is-invalid @enderror">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="poster" name="poster" value="{{old('poster')  == null ? $loker->poster : old('poster')}}">
                        <label for="poster">URL Poster</label>
                        <div class="form-text text-muted text-left">Pastikan penulisan URL diawali dengan http:// atau https://</div>
                        @error('poster')
                            <div id="poster" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('cluster') is-invalid @enderror">
                    <div class="form-material floating">
                        <input rows="4" type="text" class="form-control" id="cluster" name="cluster" value="{{old('cluster')  == null ? $loker->cluster : old('cluster')}}">
                        <label for="cluster">Cluster Lowongan</label>
                        @error('cluster')
                            <div id="cluster" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('jurusan') is-invalid @enderror">
                    <div class="form-material floating">
                        <input rows="4" type="text" class="form-control" id="jurusan" name="jurusan" value="{{old('jurusan')  == null ? $loker->jurusan : old('jurusan')}}">
                        <label for="jurusan">Jurusan Lowongan</label>
                        @error('jurusan')
                            <div id="jurusan" class="invalid-feedback animated fadeInDown">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('deadline') is-invalid @enderror">
                    <div class="form-material floating">
                        <input type="date" class="form-control" id="deadline" name="deadline" value="{{old('deadline')  == null ? $loker->deadline : old('deadline')}}">
                        <label for="deadline">Deadline</label>
                        @error('deadline')
                            <div id="deadline" class="invalid-feedback animated fadeInDown">
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