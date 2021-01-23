@extends('layouts.codebase')
@section('title')
    Kelas Alumni
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <style>
        a.delete-text::before {
            background-color: #e74c3c !important;
        }

    </style>
@endsection
@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Detail Kelas Alumni</h3>
        </div>

        <div class="block-content block-content-full">
            <div class="">

                <h3 class="h4 font-700 text-uppercase mb-5">
                    {{ $kelas->judul }}
                </h3>
                <p class="font-w500 mb-5">Kuota : {{ $kelas->kuota }}<br>Kategori : {{ $kelas->kategori }}<br>Tanggal :
                    {{ $kelas->tanggal }}
                </p>
                <div class="text-muted mb-10">
                    <span class="mr-15">
                        <i
                            class="fa fa-fw fa-calendar mr-5"></i>{{ Carbon\Carbon::parse($kelas->created_at)->diffForHumans() }}
                    </span>
                    <a class="text-muted mr-15" href="javascript:void(0)">
                        <i class="fa fa-fw fa-user mr-5"></i>{{ $kelas->uploader->name }}
                    </a>
                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block"
                        href="{{ route('kelas.edit', $kelas->id) }}">
                        <i class="fa fa-pencil mr-5"></i> Edit Kelas
                    </a>
                    <a class="link-effect text-muted mr-10 mb-5 delete-text d-inline-block"
                        href="{{ route('kelas.destroy', $kelas->id) }}">
                        <i class="fa fa-trash-o mr-5"></i> Hapus Kelas
                    </a>
                </div>

            </div>
        </div>

        <div class="block-content block-content-full">
            <h3 class="h4 font-700 text-uppercase mb-5">
                List Pembicara
            </h3>
            <!-- DataTables functionality is initialized with .js-dataTable-full-pagination class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
            <table class="table table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th class="d-none d-sm-table-cell">Tentang</th>
                        <th class="d-none d-sm-table-cell">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembicara as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="d-none d-sm-table-cell"><img src="{{ $p->foto }}" alt="" class="img-avatar"></td>
                            <td class="font-w600">{{ $p->pembicara }}</td>
                            <td class="d-none d-sm-table-cell">{{ $p->tentang }}</td>
                            <td class="d-none d-sm-table-cell">
                                <a href="{{ route('kelas.pembicara.destroy', [$kelas->id, $p->id]) }}">
                                    <button class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tambah Kelas Baru</h3>
        </div>
        <div class="block">
            <div class="block-content">
                <form class="js-validation-material" action="{{ route('kelas.pembicara.store', $kelas->id) }}"
                    method="post">
                    @csrf
                    <div class="form-group @error('nama') is-invalid @enderror">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                            <label for="nama">Nama Pembicara</label>
                            @error('nama')
                                <div id="nama" class="invalid-feedback animated fadeInDown">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('foto') is-invalid @enderror">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="foto" name="foto" value="{{ old('foto') }}">
                            <label for="foto">Link Foto</label>
                            @error('foto')
                                <div id="foto" class="invalid-feedback animated fadeInDown">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group @error('tentang') is-invalid @enderror">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="tentang" name="tentang"
                                value="{{ old('tentang') }}">
                            <label for="tentang">Berbicara tentang</label>
                            @error('tentang')
                                <div id="tentang" class="invalid-feedback animated fadeInDown">
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
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <script>
        $('.nav-item-sidebar').removeClass('active')
        $('#kelas-index').addClass("active")

    </script>
@endsection
