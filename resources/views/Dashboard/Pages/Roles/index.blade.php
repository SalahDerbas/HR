@extends('Dashboard.layouts.master')


@section('title')
Roles - Dashboard
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
    Roles
@endsection

@section('content')
<?php  use Illuminate\Support\Facades\DB;  ?>
        <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{trans('main_trans.Role_Dashboard')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @can('Add_Role')
                        <button style="margin-left: 12px; margin-top: 12px; width:20%;" type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                            {{trans('main_trans.Add_Role')}}
                        </button>
                        @endcan
                        <div class="card-body">
                            <table id="example1"  class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>{{trans('main_trans.ID')}}</th>
                                    <th>{{trans('main_trans.Name')}}</th>
                                    <th>{{trans('main_trans.Operations')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0; ?>
                                @foreach ($roles as $role)
                                    <tr>
                                         <?php $i++; ?>
                                        <td>{{ $i }}</td>
                                        <td>{{$role->name}}</td>
                                        <td>
                                            @if($role->id != 1)
                                                @can('Update_Role')
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#edit{{$role->id}}"
                                                    title=""><i class="fa fa-edit"></i></button>
                                                @endcan
                                                @can('Delete_Role')
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#delete{{$role->id}}"
                                                    title=""><i
                                                    class="fa fa-trash"></i></button>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- edit_modal_Grade -->
                                    <div class="modal fade" id="edit{{$role->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">
                                                        {{trans('main_trans.Update_Role')}}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- add_form -->
                                                    <form action="{{ route('Roles.update', 'test') }}" enctype="multipart/form-data" method="post">
                                                        {{ method_field('put') }}
                                                        @csrf
                                                        <div class="row">
                                                            <label for="firstname" class="mr-sm-2">{{trans('main_trans.Name')}}
                                                                :</label>
                                                            <input id="name" type="text" name="name" class="form-control" value="{{$role->name}}" required>
                                                            <input id="id" type="hidden" name="id" class="form-control" value="{{$role->id}}" required>
                                                        </div>
                                                        <div class="row" >
                                                            <label for="firstname" class="mr-sm-2">{{trans('main_trans.Permissions')}}
                                                                :</label>
                                                            <br>
                                                            <div class="row">
                                                                <?php
                                                                    $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
                                                                        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                                                        ->all();
                                                                    ?>
                                                                @foreach($permission as $value)
                                                                    <div class="col-lg-6">

                                                                    <label  style="font-size: 16px;margin-left: 12px;">{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                                                        {{ $value->name }}</label>
                                                                    </div>
                                                                    <br>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">{{trans('main_trans.Close')}}</button>
                                                                <button type="submit"
                                                                        class="btn btn-success">{{trans('main_trans.Submit')}}</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- delete_modal_Grade -->
                                    <div class="modal fade" id="delete{{ $role->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">
                                                        {{trans('main_trans.Delete_Role')}}
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('Roles.destroy', 'test') }}" method="post">
                                                        {{ method_field('Delete') }}
                                                        @csrf
                                                        {{trans('main_trans.Are_you_sure_delete')}} <span style="    font-weight: bolder;"> [ {{ $role->name }} ] </span> ?
                                                        <input id="id" type="hidden" name="id" class="form-control"
                                                               value="{{ $role->id }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">{{trans('main_trans.Close')}}</button>
                                                            <button type="submit"
                                                                    class="btn btn-danger">{{trans('main_trans.Submit')}}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>



        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 119%;padding: 16px;">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                            {{trans('main_trans.Add_Role')}}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- add_form -->
                        <form action="{{ route('Roles.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row">
                                    <label for="firstname" class="mr-sm-2">{{trans('main_trans.Name')}}
                                        :</label>
                                    <input id="name" type="text" name="name" class="form-control" required>
                            </div>
                            <div class="row" >
                                <label for="firstname" class="mr-sm-2">{{trans('main_trans.Permissions')}}
                                    :</label><br>
                                <div class="row">

                                @foreach($permission as $value)
                                    <div class="col-lg-6">
                                            <label style="font-size: 16px;margin-left: 12px;">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                {{ $value->name }}
                                            </label>
                                    </div>
                                @endforeach
                                </div>
                                <br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{trans('main_trans.Close')}} </button>
                                <button type="submit" class="btn btn-success">{{trans('main_trans.Submit')}} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- /.content -->
@endsection

@section('js')
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
