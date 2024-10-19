@extends('Dashboard.layouts.master')


@section('title')
Users - Dashboard
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
    Users
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{trans('main_trans.Users')}}</h3>
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
                        @can('Add_User')
                        <button style="margin-left: 12px; margin-top: 12px; width:20%;" type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                                {{trans('main_trans.Add_User')}}
                        </button>
                        @endcan
                        <div class="card-body">
                            <table id="example1"  class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>{{trans('main_trans.ID')}}</th>
                                    <th>{{trans('main_trans.Name')}}</th>
                                    <th>{{trans('main_trans.Roles')}}</th>
                                    <th>{{trans('main_trans.Email')}}</th>
                                    <th>{{trans('main_trans.Phone')}} </th>
                                    <th>{{trans('main_trans.Gender')}}</th>
                                    <th>{{trans('main_trans.Material_Status')}}</th>
                                    <th>{{trans('main_trans.Status')}}</th>
                                    <th>{{trans('main_trans.Photo')}}</th>
                                    <th style="width: 16%">{{trans('main_trans.Operations')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0; ?>
                                @foreach ($data['Users'] as $User)
                                    <tr>
                                    @if($User->status == "Active")
                                    <tr>
                                    @else
                                        <tr style="background-color: #680505;color: white;">
                                    @endif
                                        <?php $i++; ?>
                                        <td>{{ $i }}</td>
                                        <td>{{$User->name}}</td>
                                        <td>
                                                @if(!empty($User->getRoleNames()))
                                                    <ul>
                                                        @foreach($User->getRoleNames() as $v)
                                                            <li> <label >{{ $v }}</label> </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                        </td>
                                        <td>{{$User->email}}</td>
                                        <td>{{$User->phone}}</td>
                                        <td>{{$User->gender}}</td>
                                        <td>{{$User->material_status}}</td>
                                        <td>{{$User->status}}</td>
                                        <td><img src="{{$User->photo}}" width="40" height="40"></td>
                                        <td>
                                            @if($User->id != 1)

                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ trans('main_trans.Operations')}}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    @can('Update_User')
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit{{$User->id}}"> {{ trans('main_trans.Update_User')}}</a>
                                                    @endcan
                                                    @can('Delete_User')
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete{{$User->id}}"> {{ trans('main_trans.Delete_User')}}</a>
                                                    @endcan
                                                    @can('Activate_User')
                                                        <a class="dropdown-item" href="{{ route('Dashboard.Users.activate',['id'=>$User->id]) }}">
                                                        @if($User->status == "Active")
                                                        {{ trans('main_trans.Inativate_User')}}
                                                        @else
                                                        {{ trans('main_trans.Activate_User')}}
                                                        @endif
                                                    </a>
                                                    @endcan
                                                </div>
                                            </div>


                                            @endif
                                        </td>
                                    </tr>




                                    <!-- edit_modal_Grade -->
                                    <div class="modal fade" id="edit{{$User->id}}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">
                                                        {{trans('main_trans.Update_User')}}

                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>


                                                <div class="modal-body">
                                                    <!-- add_form -->
                                                    <form action="{{ route('Dashboard.Users.update') }}" enctype="multipart/form-data" method="post">
                                                        {{ method_field('put') }}
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="firstname" class="mr-sm-2">{{trans('main_trans.Firstname')}}
                                                                    :</label>
                                                                <input id="firstname" type="text" name="firstname" class="form-control" value="{{$User->firstname}}" required>
                                                                <input id="id" type="hidden" name="id" class="form-control" value="{{$User->id}}">
                                                            </div>

                                                            <div class="col">
                                                                <label for="lastname" class="mr-sm-2">{{trans('main_trans.Lastname')}}
                                                                    :</label>
                                                                <input id="lastname" type="text" name="lastname" class="form-control" value="{{$User->lastname}}" required>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="name" class="mr-sm-2">{{trans('main_trans.Name')}}
                                                                    :</label>
                                                                <input id="name" type="text" name="name" class="form-control" value="{{$User->name}}" required>

                                                            </div>
                                                            <div class="col">
                                                                <label for="name" class="mr-sm-2">{{trans('main_trans.Password')}}
                                                                    :</label>
                                                                <input id="password" type="password" name="password" class="form-control" value="{{$User->password}}" required>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="email" class="mr-sm-2">{{trans('main_trans.Email')}}
                                                                    :</label>
                                                                <input id="email" type="email" name="email" class="form-control" value="{{$User->email}}" required>
                                                            </div>
                                                            <div class="col">
                                                                <label for="phone" class="mr-sm-2">{{trans('main_trans.Phone')}}
                                                                    :</label>
                                                                <input id="phone" type="number" name="phone" class="form-control" value="{{$User->phone}}"  required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="phone" class="mr-sm-2">{{trans('main_trans.Gender')}}
                                                                    :</label>
                                                                <select id="gender" name="gender" class="form-select form-control" >
                                                                    <option value="Male"  {{$User->gender == 'Male' ? 'selected' : ""}} >{{ trans('main_trans.Male') }}</option>
                                                                    <option value="Female" {{$User->gender == 'Female' ? 'selected' : ""}} >{{ trans('main_trans.Female') }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="col">
                                                                <label for="phone" class="mr-sm-2">{{ trans('main_trans.Material_Status') }}
                                                                    :</label>
                                                                <select id="material_status" name="material_status" class="form-select form-control">
                                                                    <option value="Single" {{$User->material_status == 'Single' ? 'selected' : ""}}>{{ trans('main_trans.Single') }}</option>
                                                                    <option value="Married" {{$User->material_status == 'Married' ? 'selected' : ""}} >{{ trans('main_trans.Married') }}</option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <label  class="mr-sm-2">{{ trans('main_trans.Photo') }}</label>
                                                                <input type="file" name="photo" id="photo" style="width: 100%">

                                                            </div>
                                                            <div class="col">
                                                                <label for="phone" class="mr-sm-2">{{ trans('main_trans.Status') }}:</label>
                                                                <select id="status" name="status" class="form-select form-control">
                                                                    <option value="Active" {{$User->status == 'Active' ? 'selected' : ""}} >{{ trans('main_trans.Active') }}</option>
                                                                    <option value="Inactive" {{$User->status == 'Inactive' ? 'selected' : ""}} >{{ trans('main_trans.Inactive') }}</option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                                <label for="inputSkills" class="col-sm-4 col-form-label">{{trans('main_trans.Roles')}}</label>
                                                                <div class="col-sm-8">
                                                                    {!! Form::select('roles[]', $data['roles'] ,$User->getRoleNames() , array('class' => 'form-control','multiple'))
                                                                    !!}
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
                                    <div class="modal fade" id="delete{{ $User->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">
                                                        {{trans('main_trans.Delete_User')}}

                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('Dashboard.Users.destroy', 'test') }}" method="post">
                                                        {{ method_field('Delete') }}
                                                        @csrf
                                                        {{trans('main_trans.Are_you_sure_delete')}}   <span style="    font-weight: bolder;">{{$User->name}} </span>?
                                                        <input id="id" type="hidden" name="id" class="form-control"
                                                               value="{{ $User->id }}">
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


        <!-- add_modal_Notifications -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                            {{trans('main_trans.Users')}}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- add_form -->
                        <form action="{{ route('Dashboard.Users.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="firstname" class="mr-sm-2">{{trans('main_trans.Firstname')}}
                                        :</label>
                                    <input id="firstname" type="text" name="firstname" class="form-control" required>
                                </div>

                                <div class="col">
                                    <label for="lastname" class="mr-sm-2">{{trans('main_trans.Lastname')}}
                                        :</label>
                                    <input id="lastname" type="text" name="lastname" class="form-control" required>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="mr-sm-2">{{trans('main_trans.Name')}}
                                        :</label>
                                    <input id="name" type="text" name="name" class="form-control" required>

                                </div>
                                <div class="col">
                                    <label for="name" class="mr-sm-2">{{trans('main_trans.Password')}}
                                        :</label>
                                    <input id="password" type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                        <label for="email" class="mr-sm-2">{{trans('main_trans.Email')}}
                                            :</label>
                                        <input id="email" type="email" name="email" class="form-control" required>
                                    </div>
                                <div class="col">
                                    <label for="phone" class="mr-sm-2">{{trans('main_trans.Phone')}}
                                        :</label>
                                    <input id="phone" type="number" name="phone" class="form-control" required>
                                </div>
                          </div>

                            <div class="row">
                                <div class="col">
                                    <label for="phone" class="mr-sm-2">{{trans('main_trans.Gender')}}
                                        :</label>
                                    <select id="gender" name="gender" class="form-select form-control" >
                                        <option selected value="Male">{{ trans('main_trans.Male') }}</option>
                                        <option value="Female">{{ trans('main_trans.Female') }}</option>
                                    </select>

                                </div>
                                <div class="col">
                                    <label for="phone" class="mr-sm-2">{{ trans('main_trans.Material_Status') }}
                                        :</label>
                                    <select id="material_status" name="material_status" class="form-select form-control">
                                        <option selected value="Single">{{ trans('main_trans.Single') }}</option>
                                        <option value="Married">{{ trans('main_trans.Married') }}</option>
                                    </select>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label  class="col-sm-2">{{ trans('main_trans.Photo') }}</label>
                                        <input type="file" name="photo" id="photo" style="width: 100%">

                                </div>
                                <div class="col">
                                    <label for="phone" class="mr-sm-2">{{ trans('main_trans.Status') }}:</label>
                                    <select id="status" name="status" class="form-select form-control">
                                        <option selected value="Active">{{ trans('main_trans.Active') }}</option>
                                        <option value="Inactive">{{ trans('main_trans.Inactive') }}</option>
                                    </select>

                                </div>
                            </div>

                            <br>
                            <div class="row">
                                    <label for="inputSkills" class="col-sm-4 col-form-label">{{trans('main_trans.Roles')}}</label>
                                    <div class="col-sm-8">
                                        {!! Form::select('roles_name[]', $data['roles'] ,[], array('class' => 'form-control','multiple')) !!}
                                    </div>
                            </div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{trans('main_trans.Close')}} </button>
                        <button type="submit" class="btn btn-success">{{trans('main_trans.Submit')}}</button>
                    </div>
                    </form>
                </div>
            </div>
            </div>
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
