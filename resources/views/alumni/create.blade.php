@extends('layouts.codebase')
@section('title')
    Tambah Alumni
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-10">
        <!-- Simple Wizard 2 -->
        <div class="js-wizard-simple block">
            <!-- Step Tabs -->
            <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#wizard-simple2-step1" data-toggle="tab">1. Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#wizard-simple2-step2" data-toggle="tab">2. Personal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#wizard-simple2-step3" data-toggle="tab">3. Work</a>
                </li>
            </ul>
            <!-- END Step Tabs -->

            <!-- Form -->
            <form action="be_forms_wizard.html" method="post">
                <!-- Steps Content -->
                <div class="block-content block-content-full tab-content" style="min-height: 267px;">
                    <!-- Step 1 -->
                    <div class="tab-pane active" id="wizard-simple2-step1" role="tabpanel">
                        <div class="form-group @error('email') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="email" id="email" name="email" value="{{old('email')}}">
                                <label for="email">Email</label>
                                @error('email')
                                    <div id="email-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group @error('username') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="username" name="username" value="{{old('username')}}">
                                <label for="username">Username</label>
                                @error('username')
                                    <div id="username-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group @error('password') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="password" id="password" name="password" value="{{old('password')}}">
                                <label for="password">Password</label>
                                @error('password')
                                    <div id="password-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-material floating">
                                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
                                <label for="password_confirmation">Konfirmasi Password</label>
                            </div>
                        </div>
                    </div>
                    <!-- END Step 1 -->

                    <!-- Step 2 -->
                    <div class="tab-pane" id="wizard-simple2-step2" role="tabpanel">
                        <div class="form-group @error('namalengkap') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="namalengkap" id="namalengkap" name="namalengkap" value="{{old('namalengkap')}}">
                                <label for="namalengkap">Nama Lengkap</label>
                                @error('namalengkap')
                                    <div id="namalengkap-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6 @error('jurusan') is-invalid @enderror">
                                <div class="form-material floating">
                                    <select class="form-control" id="material-select" name="material-select">
                                        <option></option>                                        
                                        <option value="Matematika">Matematika</option>
                                        <option value="Sistem Informasi">Sistem Informasi</option>
                                        <option value="Teknik Biomedis">Teknik Biomedis</option>
                                        <option value="Teknik Lingkungan">Teknik Lingkungan</option>
                                        <option value="Statistika">Statistika</option>
                                        <option value="Kimia">Kimia</option>
                                        <option value="Biologi">Biologi</option>
                                        <option value="Fisika">Fisika</option>
                                    </select>
                                    <label for="material-select">Jurusan</label>
                                    @error('jurusan')
                                        <div id="jurusan-error" class="invalid-feedback animated fadeInDown">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-6 @error('angkatan') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input class="form-control" type="number" id="angkatan" name="angkatan" value="{{old('angkatan')}}">
                                    <label for="angkatan">Angkatan</label>
                                    @error('angkatan')
                                        <div id="angkatan-error" class="invalid-feedback animated fadeInDown">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group @error('domisili') is-invalid @enderror">
                            <div class="form-material">
                                <input type="text" class="js-autocomplete form-control" id="domisili" name="domisili" placeholder="Kota domisili">
                                <label for="domisili">Domisili</label>
                                @error('domisili')
                                    <div id="domisili-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group @error('alamat') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="alamat" name="alamat" value="{{old('alamat')}}">
                                <label for="alamat">Alamat</label>
                                @error('alamat')
                                    <div id="alamat-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-4 @error('tempat_lahir') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{old('tempat_lahir')}}">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    @error('tempat_lahir')
                                        <div id="tempat_lahir-error" class="invalid-feedback animated fadeInDown">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-4 @error('tgl_lahir') is-invalid @enderror">
                                <div class="form-material">
                                    <input type="text" class="js-datepicker form-control" id="tgl_lahir" name="tgl_lahir" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" value="{{old('tgl_lahir')}}">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    @error('tgl_lahir')
                                        <div id="tgl_lahir-error" class="invalid-feedback animated fadeInDown">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-4 @error('umur') is-invalid @enderror">
                                <div class="form-material floating">
                                    <input type="number" class="form-control" id="umur" name="umur" value="{{old('umur')}}">
                                    <label for="umur">Umur</label>
                                    @error('umur')
                                        <div id="umur-error" class="invalid-feedback animated fadeInDown">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-30 @error('jenis_kelamin') is-invalid @enderror">
                            <div class="col-12">
                                <p>Jenis Kelamin</p>
                            </div>
                            <div class="col-6">
                                <label class="css-control css-control-primary css-radio">
                                    <input type="radio" class="css-control-input" name="jenis_kelamin" checked>
                                    <span class="css-control-indicator"></span> Laki-laki
                                </label>
                                <label class="css-control css-control-primary css-radio">
                                    <input type="radio" class="css-control-input" name="jenis_kelamin">
                                    <span class="css-control-indicator"></span> Perempuan
                                </label>
                            </div>
                            @error('jenis_kelamin')
                                <div id="jenis_kelamin-error" class="invalid-feedback animated fadeInDown">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group @error('foto') is-invalid @enderror">
                            <div class="custom-file">
                                <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                <input type="file" accept="image/*" class="custom-file-input" id="profile-settings-avatar" name="profile-settings-avatar" data-toggle="custom-file-input">
                                <label class="custom-file-label" for="profile-settings-avatar">Upload foto</label>
                                @error('foto')
                                <div id="foto-error" class="invalid-feedback animated fadeInDown">
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <!-- END Step 2 -->

                    <!-- Step 3 -->
                    <div class="tab-pane" id="wizard-simple2-step3" role="tabpanel">
                        <div class="form-group @error('perusahaan') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="perusahaan" name="perusahaan" value="{{old('perusahaan')}}">
                                <label for="perusahaan">Nama Perusahaan</label>
                                @error('perusahaan')
                                    <div id="perusahaan-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group @error('cluster') is-invalid @enderror">
                            <div class="form-material floating">
                                <select class="form-control" id="material-select" name="material-select">
                                    <option></option>                                        
                                    <option value="Akademisi/Studi Lanjut">Akademisi/Studi Lanjut</option>
                                    <option value="ASN/PNS">ASN/PNS</option>
                                    <option value="Enterpreneur">Enterpreneur</option>
                                    <option value="Freelance">Freelance</option>
                                    <option value="NGO/LSM">NGO/LSM</option>
                                    <option value="Professional">Professional</option>
                                </select>
                                <label for="material-select">cluster</label>
                                @error('cluster')
                                    <div id="cluster-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group @error('jabatan') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="jabatan" name="jabatan" value="{{old('jabatan')}}">
                                <label for="jabatan">Jabatan</label>
                                @error('jabatan')
                                    <div id="jabatan-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group @error('thn_masuk') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="thn_masuk" name="thn_masuk" value="{{old('thn_masuk')}}">
                                <label for="thn_masuk">Tahun Masuk Kerja</label>
                                @error('thn_masuk')
                                    <div id="thn_masuk-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group @error('linkedin') is-invalid @enderror">
                            <div class="form-material floating">
                                <input class="form-control" type="text" id="linkedin" name="linkedin" value="{{old('linkedin')}}">
                                <label for="linkedin">Linkedin</label>
                                <small class="text-muted">Mohon penulisan didahului dengan http://</small>
                                @error('linkedin')
                                    <div id="linkedin-error" class="invalid-feedback animated fadeInDown">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- END Step 3 -->
                </div>
                <!-- END Steps Content -->

                <!-- Steps Navigation -->
                <div class="block-content block-content-sm block-content-full bg-body-light">
                    <div class="row">
                        <div class="col-6">
                            <button type="button" class="btn btn-alt-secondary" data-wizard="prev">
                                <i class="fa fa-angle-left mr-5"></i> Previous
                            </button>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                                Next <i class="fa fa-angle-right ml-5"></i>
                            </button>
                            <button type="submit" class="btn btn-alt-primary d-none" data-wizard="finish">
                                <i class="fa fa-check mr-5"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
                <!-- END Steps Navigation -->
            </form>
            <!-- END Form -->
        </div>
        <!-- END Simple Wizard 2 -->
    </div>
</div>
@endsection
@section('script')
    <!-- Page JS Plugins -->
    <script src="{{asset('assets/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js')}}"></script>
    <script src="{{asset('assets/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/jquery-validation/additional-methods.js')}}"></script>
    <script src="{{asset('assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/be_forms_plugins.min.js')}}"></script>

    <!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
    <script>jQuery(function(){ Codebase.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); });</script>

    <!-- Page JS Code -->
    <script src="{{asset('assets/js/pages/be_forms_wizard.min.js')}}"></script>
    <script>
        $('.nav-item-sidebar').removeClass('active');
        $('#alumni-create').addClass('active');
    </script>
@endsection