@extends('layouts.codebase')

@section('title')
    My Profile
@endsection
@section('style')

@endsection

@section('content')
    <!-- Page Content -->
    <!-- User Info -->
    <div class="bg-image bg-image-bottom" style="background-image: url({{ url('assets/media/photos/photo34@2x.jpg') }})">
        <div class="bg-black-op-75 py-30">
            <div class="content content-full text-center">
                <!-- Avatar -->
                <div class="mb-15">
                    <a class="img-link" href="be_pages_generic_profile.php">
                        <img class="img-avatar img-avatar96 img-avatar-thumb"
                            src="{{ url('assets/media/avatars/avatar15.jpg') }}" alt="">
                    </a>
                </div>
                <!-- END Avatar -->

                <!-- Personal -->
                <h1 class="h3 text-white font-w700 mb-10">
                    {{ Auth::user()->name }}
                </h1>
                <h2 class="h5 text-white-op">
                    SUPERADMIN
                </h2>
                <!-- END Personal -->

                <!-- Actions -->
                {{-- <button type="button" class="btn btn-rounded btn-hero btn-sm btn-alt-success mb-5">
                    <i class="fa fa-plus mr-5"></i> Add Friend
                </button>
                <button type="button" class="btn btn-rounded btn-hero btn-sm btn-alt-primary mb-5">
                    <i class="fa fa-envelope-o mr-5"></i> Message
                </button> --}}
                <a class="btn btn-rounded btn-hero btn-sm btn-alt-secondary mb-5 px-20" href="{{ route('my.edit') }}">
                    <i class="fa fa-pencil mr-5"></i> Edit Profile
                </a>
                <button type="button" class="btn btn-rounded btn-hero btn-sm ml-5 mb-5 px-20 btn-alt-success"
                    data-toggle="modal" data-target="#modal-fadein"><i class="fa fa-group mr-5"></i> Tambahkan
                    Admin</button>
                <!-- END Actions -->
            </div>
        </div>
    </div>
    <!-- END User Info -->

    <!-- Fade In Modal -->
    <div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('my.addadmin') }}" method="post">
                    @csrf
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-gd-emerald">
                            <h3 class="block-title">Tambahkan Admin</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="name">Name</label>
                                <div class="col-lg-7">
                                    <input type="name" class="form-control" id="name" name="name"
                                        placeholder="Enter Name..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="email">Email</label>
                                <div class="col-lg-7">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter Email..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label" for="password">Password</label>
                                <div class="col-lg-7">
                                    <input type="text" disabled value="password" class="form-control" id="password"
                                        name="password" placeholder="Enter Password..">
                                    <div class="form-text text-muted">Default Password, akan diubah oleh admin itu sendiri
                                        ketika login</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-alt-success">
                            <i class="fa fa-group"></i> Tambahkan Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Fade In Modal -->

    <!-- Main Content -->
    <div class="content">

        <!-- Alert Table -->
        <div class="block">
            {{-- <div class="block-header block-header-default">
                <h3 class="block-title">Variations</h3>
            </div> --}}
            <div class="block-content">
                <div class="row">
                    @if (Session::has('success'))
                        <div class="col-md-6">
                            <!-- Success Alert -->
                            <div class="alert alert-success alert-dismissable" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h3 class="alert-heading font-size-h4 font-w400">Success</h3>
                                <p class="mb-0">{{ Session::get('success') }}</p>
                            </div>
                            <!-- END Success Alert -->
                        </div>
                    @endif
                    @error('name')
                        <div class="col-md-6">
                            <!-- Danger Alert -->
                            <div class="alert alert-danger alert-dismissable" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h3 class="alert-heading font-size-h4 font-w400">Error</h3>
                                <p class="mb-0">{{ $message }}</p>
                            </div>
                            <!-- END Danger Alert -->
                        </div>
                    @enderror
                    @error('email')
                        <div class="col-md-6">
                            <!-- Danger Alert -->
                            <div class="alert alert-danger alert-dismissable" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h3 class="alert-heading font-size-h4 font-w400">Error</h3>
                                <p class="mb-0">{{ $message }}</p>
                            </div>
                            <!-- END Danger Alert -->
                        </div>
                    @enderror
                </div>
            </div>
        </div>
        <!-- END Alert Table -->

        <!-- Bordered Table -->
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">List Admin</h3>
                <div class="block-options">
                    <div class="block-options-item">
                        {{-- <code>.table-bordered</code> --}}
                    </div>
                </div>
            </div>

            <div class="block-content">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;"></th>
                            <th>Name</th>
                            <th class="d-none d-sm-table-cell">Email</th>
                            <th class="d-none d-sm-table-cell" style="width: 10px;"></th>
                            <th class="text-center" style="width: 15%;">Access</th>
                            {{-- <th class="text-center" style="width: 100px;">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $u)

                            <tr>
                                <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                <td class="font-w600">{{ $u->name }}</td>
                                <td class="d-none d-sm-table-cell">{{ $u->email }}</td>
                                <td class="d-none d-sm-table-cell"></td>
                                <td class="text-center">
                                    @if ($u->role == 1)
                                        <span class="badge badge-success">SUPERADMIN</span>
                                    @else
                                        <span class="badge badge-info">ADMIN</span>
                                    @endif
                                </td>
                                {{-- <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn {{ $u->role == 1 ? 'disabled' : '' }} btn-sm btn-secondary"
                                            data-toggle="tooltip" title="Make SuperAdmin">
                                            <i class="fa fa-link"></i>
                                        </button>
                                        <button type="button"
                                            class="btn {{ $u->role == 1 ? '' : 'disabled' }} btn-sm btn-secondary"
                                            data-toggle="tooltip" title="Remove SuperAdmin">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td> --}}
                            </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

        <!-- END Bordered Table -->

    </div>
    <!-- END Main Content -->
    <!-- END Page Content -->
@endsection

@section('script')
    <script src="{{ url('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('assets/js/pages/be_tables_datatables.min.js') }}"></script>
@endsection
