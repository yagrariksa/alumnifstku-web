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
                <form class="js-validation-material" action="{{ route('loker.store') }}" method="post">
                    @csrf
                    <div class="form-group @error('jabatan') is-invalid @enderror">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="jabatan" name="jabatan"
                                value="{{ old('jabatan') }}">
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
                            <input type="text" class="form-control" id="perusahaan" name="perusahaan"
                                value="{{ old('perusahaan') }}">
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
                            <textarea rows="4" type="text" class="form-control" id="deskripsi"
                                name="deskripsi">{{ old('deskripsi') }}</textarea>
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
                            <input type="text" class="form-control" id="link" name="link" value="{{ old('link') }}">
                            <label for="link">URL Loker</label>
                            <div class="form-text text-muted text-left">Pastikan penulisan URL diawali dengan http:// atau
                                https://</div>
                            @error('link')
                                <div id="link" class="invalid-feedback animated fadeInDown">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('poster') is-invalid @enderror">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="poster" name="poster" value="{{ old('poster') }}">
                            <label for="poster">URL Poster</label>
                            <div class="form-text text-muted text-left">Pastikan penulisan URL diawali dengan http:// atau
                                https://</div>
                            @error('poster')
                                <div id="poster" class="invalid-feedback animated fadeInDown">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('cluster') is-invalid @enderror">
                        <div class="form-material">
                            <select class="form-control" name="cluster" id="cluster">
                                <option value="Akademisi/Studi Lanjut">Akademisi/Studi Lanjut</option>
                                <option value="ASN/PNS">ASN/PNS</option>
                                <option value="Enterpreneur">Enterpreneur</option>
                                <option value="Freelance">Freelance</option>
                                <option value="NGO/LSM">NGO/LSM</option>
                                <option value="Professional">Professional</option>
                            </select>
                            <label for="cluster">Cluster Lowongan</label>
                            @error('cluster')
                                <div id="cluster" class="invalid-feedback animated fadeInDown">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('jurusan') is-invalid @enderror">
                        <div class="form-material">
                            <label for="">Jurusan Lowongan</label>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sistem informasi"
                                    value="sistem informasi" id="sisteminformasi">
                                <label class="form-check-label" for="sisteminformasi">
                                    sistem informasi
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="teknik lingkungan"
                                    value="teknik lingkungan" id="tekniklingkungan">
                                <label class="form-check-label" for="tekniklingkungan">
                                    teknik lingkungan
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="teknik biomedis"
                                    value="teknik biomedis" id="teknikbiomedis">
                                <label class="form-check-label" for="teknikbiomedis">
                                    teknik biomedis
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="matematika" value="matematika"
                                    id="matematika">
                                <label class="form-check-label" for="matematika">
                                    matematika
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fisika" value="fisika" id="fisika">
                                <label class="form-check-label" for="fisika">
                                    fisika
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="biologi" value="biologi" id="biologi">
                                <label class="form-check-label" for="biologi">
                                    biologi
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="kimia" value="kimia" id="kimia">
                                <label class="form-check-label" for="kimia">
                                    kimia
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="statistika" value="statistika"
                                    id="statistika">
                                <label class="form-check-label" for="statistika">
                                    statistika
                                </label>
                            </div>

                            @error('jurusan')
                                <div id="jurusan" class="invalid-feedback animated fadeInDown">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('deadline') is-invalid @enderror">
                        <div class="form-material">
                            <input type="date" class="form-control" id="deadline" name="deadline"
                                value="{{ old('deadline') }}">
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
    <script src="{{ asset('assets/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_forms_validation.min.js') }}"></script>
    <script>
        $('.nav-item-sidebar').removeClass('active')
        $('#loker-create').addClass("active")

    </script>
@endsection
