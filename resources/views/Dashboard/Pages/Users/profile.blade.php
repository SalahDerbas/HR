@extends('Dashboard.layouts.master')


@section('title')
Profile - Dashboard
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
    Profile
@endsection

@section('content')


<section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ trans('main_trans.Profile_Informations') }}</h3>
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
                                                            <form action="{{ route('Dashboard.Users.updateProfile') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group row">
                                                                            <label for="inputEmail" class="col-sm-2 col-form-label">{{ trans('main_trans.Email') }}</label>
                                                                            <div class="col-sm-10">
                                                                                <input type="email" class="form-control" name="email" id="email" placeholder="{{ trans('main_trans.Email') }}" value="{{Auth::user()->email}}">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group row">
                                                                            <label for="inputName" class="col-sm-4 col-form-label">{{ trans('main_trans.Name') }} </label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" name="name" id="name" placeholder="{{ trans('main_trans.Name') }}" value="{{Auth::user()->name}}">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group row">
                                                                            <label for="inputExperience" class="col-sm-4 col-form-label">{{ trans('main_trans.Phone') }} </label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" class="form-control" name="phone" id="phone" placeholder="{{ trans('main_trans.Phone') }} " value="{{Auth::user()->phone}}">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group row">
                                                                            <label for="inputSkills" class="col-sm-4 col-form-label">{{ trans('main_trans.Firstname') }}  </label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="{{ trans('main_trans.Firstname') }}" value="{{ Auth::user()->firstname }}">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group row">
                                                                            <label for="inputSkills" class="col-sm-4 col-form-label">{{ trans('main_trans.Lastname') }}</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="{{ trans('main_trans.Lastname') }}" value="{{ Auth::user()->lastname }}">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group row">
                                                                            <label for="inputSkills" class="col-sm-4 col-form-label">{{ trans('main_trans.Gender') }} </label>
                                                                            <div class="col-sm-8">
                                                                                <select id="gender" name="gender" class="form-select form-control" >
                                                                                    <option selected value="Male">{{ trans('main_trans.Male') }}</option>
                                                                                    <option value="Female">{{ trans('main_trans.Female') }}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group row">
                                                                            <label for="inputSkills" class="col-sm-4 col-form-label">{{ trans('main_trans.Material_Status') }} </label>
                                                                            <div class="col-sm-8">
                                                                                <select id="material_status" name="material_status" class="form-select form-control">
                                                                                    <option selected value="Single">{{ trans('main_trans.Single') }} </option>
                                                                                    <option value="Married">{{ trans('main_trans.Married') }} </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group row">
                                                                            <label for="inputSkills" class="col-sm-4 col-form-label">{{ trans('main_trans.Photo') }}  </label>
                                                                            <div class="col-sm-8">
                                                                                <input type="file" name="photo" id="photo">
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="form-group row">

                                                                        <div class="col-sm-4" ></div>
                                                                            <div class="col-sm-8" >
                                                                            @if(Auth::user()->photo)
                                                                                <img class="profile-user-img "
                                                                                     src="{{ Auth::user()->photo }}"
                                                                                     alt="User profile picture">
                                                                            @endif

                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="offset-sm-2 col-sm-10">
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


