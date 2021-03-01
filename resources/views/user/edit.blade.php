@extends('layouts.codebase')

@section('title')
    My Profile
@endsection
@section('style')

@endsection

@section('content')
    <!-- Page Content -->
    <!-- User Info -->
    <div class="bg-image bg-image-bottom" style="background-image: url({{ url('assets/media/photos/photo34@2x.jpg') }});">
        <div class="bg-black-op-75 py-30">
            <div class="content content-full text-center">
                <!-- Avatar -->
                <div class="mb-15">
                    <a class="img-link" href="#">
                        <img class="img-avatar img-avatar96 img-avatar-thumb"
                            src="{{ url('assets/media/avatars/avatar15.jpg') }}" alt="">
                    </a>
                </div>
                <!-- END Avatar -->

                <!-- Personal -->
                <h1 class="h3 text-white font-w700 mb-10">{{ Auth::user()->name }}</h1>
                <h2 class="h5 text-white-op">
                    @if (Auth::user()->role == 1)
                        SUPERADMIN
                    @else
                        ADMIN
                    @endif
                </h2>
                <!-- END Personal -->

                <!-- Actions -->
                @if (Auth::user()->role == 1)
                <a class="btn btn-rounded btn-hero btn-sm btn-alt-success mb-5 px-20" href="{{ route('my.admin') }}">
                    <i class="fa fa-group mr-5"></i> List Admin / Tambahkan Admin
                </a>
                @endif
                <!-- <a href="be_pages_generic_profile.php" class="btn btn-rounded btn-hero btn-sm btn-alt-secondary mb-5">
                            <i class="fa fa-arrow-left mr-5"></i> Back to Profile
                        </a> -->
                <!-- END Actions -->
            </div>
        </div>
    </div>
    <!-- END User Info -->

    <!-- Main Content -->
    <div class="content">
        <div class="block">
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


                    @if (Session::has('error'))

                        <div class="col-md-6">
                            <!-- Danger Alert -->
                            <div class="alert alert-danger alert-dismissable" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h3 class="alert-heading font-size-h4 font-w400">Error</h3>
                                <p class="mb-0">{{ Session::get('error') }}</p>
                            </div>
                            <!-- END Danger Alert -->
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- User Profile -->
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-user-circle mr-5 text-muted"></i> User Profile
                </h3>
            </div>
            <div class="block-content">
                <form action="{{ route('my.update') }}" method="post">
                    @csrf
                    <div class="row items-push">
                        <div class="col-lg-3">
                            <p class="text-muted">
                                Your account’s vital info. Your username will be publicly visible.
                            </p>
                        </div>
                        <div class="col-lg-7 offset-lg-1">
                            {{-- <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-username">Username</label>
                                    <input type="text" class="form-control form-control-lg" id="profile-settings-username" name="profile-settings-username" placeholder="Enter your username.." value="john.doe">
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-name">Name</label>
                                    <input type="text" class="form-control form-control-lg" id="profile-settings-name"
                                        name="name" placeholder="Enter your name.." value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-email">Email Address</label>
                                    <input type="email" class="form-control form-control-lg" id="profile-settings-email"
                                        name="email" placeholder="Enter your email.." value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <div class="col-md-10 col-xl-6">
                                    <div class="push">
                                        <img class="img-avatar" src="{{url('assets/media/avatars/avatar15.jpg')}}" alt="">
                                    </div>
                                    <div class="custom-file">
                                        <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                        <input type="file" class="custom-file-input" id="profile-settings-avatar" name="profile-settings-avatar" data-toggle="custom-file-input">
                                        <label class="custom-file-label" for="profile-settings-avatar">Choose new avatar</label>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-alt-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END User Profile -->

        <!-- Change Password -->
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-asterisk mr-5 text-muted"></i> Change Password
                </h3>
            </div>
            <div class="block-content">
                <form action="{{ route('my.cpass') }}" method="post">
                    @csrf
                    <div class="row items-push">
                        <div class="col-lg-3">
                            <p class="text-muted">
                                Changing your sign in password is an easy way to keep your account secure.
                            </p>
                        </div>
                        <div class="col-lg-7 offset-lg-1">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-password">Current Password</label>
                                    <input type="password" class="form-control form-control-lg"
                                        id="profile-settings-password" name="password_current">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-password-new">New Password</label>
                                    <input type="password" class="form-control form-control-lg"
                                        id="profile-settings-password-new" name="password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="profile-settings-password-new-confirm">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-lg"
                                        id="profile-settings-password-new-confirm" name="password_confirmation">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-alt-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Change Password -->

    </div>
    <!-- END Main Content -->
    <!-- END Page Content -->
@endsection

@section('script')

@endsection
