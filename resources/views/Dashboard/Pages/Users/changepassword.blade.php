@extends('Dashboard.layouts.master')


@section('title')
Reset Password - Dashboard
@stop

@section('css')
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('title_page1')
    {{trans('main_trans.Dashboard')}}
@endsection

@section('title_page2')
    Reset Password
@endsection

@section('content')


<section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ trans('main_trans.Reset_Password') }}</h3>
                        </div>
                            <section class="content">
                                <div class="container-fluid" style="padding-top: 10px;">
                                    <div class="row">
                                        <div class="col-md-3">

                                            <!-- Profile Image -->
                                            <div class="card card-primary card-outline" style="border-bottom: 9px solid #007bff;">
                                                <div class="card-body box-profile">
                                                    <div class="text-center">
                                                        <img class="profile-user-img img-fluid img-circle"
                                                             src="{{ Auth::user()->photo }}"
                                                             alt="User profile picture">
                                                    </div>

                                                    <h3 class="profile-username text-center">{{ Auth::user()->name; }}</h3>

                                                    <p class="text-muted text-center">{{ Auth::user()->email; }}</p>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-9">
                                            <div class="card">

                                                <div class="card-body">
                                                    <div class="tab-content">
                                                        <div class="active tab-pane" id="settings">


                                                        <form action="{{ route('Dashboard.Users.updatePassword') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group row">
                                                                        <label for="inputEmail" class="col-sm-4 col-form-label">{{ trans('main_trans.New_Password') }}</label>

                                                                        <div class="col-sm-8">
                                                                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="{{ trans('main_trans.New_Password') }}" >
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group row">
                                                                        <label for="inputEmail" class="col-sm-4 col-form-label">{{ trans('main_trans.Confirm_Password') }}</label>

                                                                        <div class="col-sm-8">
                                                                            <input type="password" class="form-control" name="new_password_confirmation" id="confirmNewPasswordInput" placeholder="{{ trans('main_trans.Confirm_Password') }}" >
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <br><br><br><br>
                                                            <div class="form-group row">
                                                                <div class="offset-sm-6 col-sm-6">
                                                                    <button type="submit" class="btn btn-danger">{{ trans('main_trans.Submit') }} </button>
                                                                </div>
                                                            </div>
                                                        </form>


                                                    </div>
                                                        <!-- /.tab-pane -->
                                                    </div>
                                                    <!-- /.tab-content -->
                                                </div><!-- /.card-body -->
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div><!-- /.container-fluid -->
                            </section>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>


    </section>


@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection


