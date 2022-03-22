<div class="col-xs-12">
    <h4><span class="glyphicon glyphicon-user"></span> Administrators</h4>
    <hr>
    @if(count($userRoles) > 0)
    @else
    <p class="text-danger"><b>Nobody currently has the SUPER ADMIN role.</b></p>
    @endif

    <div class="container-fluid">

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Administrators</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table dataTable js-exportable">
                                <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th style="width:40px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userRoles as $row)
                                    <tr>
                                        <td><strong>{{$row->name}}</strong></td>
                                        <td><strong><a href="mailto:{{$row->email}}"></a>{{$row->email}}</strong></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm  " data-toggle="modal"
                                                data-target="#deleteAdministratorModal_{{$row->idUserRole}}"><span
                                                    class="glyphicon glyphicon-remove"></span></button>
                                        </td>
                                    </tr>
                                    <!-- +AJO : Model section begin -->
                                    <div class="modal fade" id="deleteAdministratorModal_{{$row->idUserRole}}"
                                        tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content bg-danger">
                                                <div class="modal-header">
                                                    <h4 class="title col-white text-center" id="defaultModalLabel">
                                                        Delete Administrator Confirmation</h4>
                                                </div>
                                                <div class="modal-body col-white">
                                                    {{ Form::open(['action' => ['UserRoleController@destroy', $row->idUserRole], 'method' => 'POST']) }}
                                                    @csrf
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    <div class="form-group">
                                                        <label for="userRole_id"><b>Do you really want to delete the
                                                                super admin role for {{$row->name}}?</b></label>
                                                        <input name="userRole_id" type="hidden"
                                                            value="{{$row->idUserRole}}">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-link waves-effect col-white">Yes, delete</button>
                                                    <button type="button" class="btn btn-link waves-effect col-white"
                                                        data-dismiss="modal">No, cancel</button>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end model section -->
                                    @endforeach
                                    <!-- Adding new line -->
                                    <tr>
                                        {{ Form::open(['action' => 'UserRoleController@store', 'method' => 'POST']) }}
                                        <td>
                                            <div class="form-group form-float">
                                                {{form::text('username', '', ['class' => 'form-control', 'placeholder' => 'User name'])}}
                                            </div>

                                        </td>
                                        <td>

                                            <div class="form-group form-float">
                                                {{form::text('email', '', ['class' => 'form-control', 'placeholder' => 'email'])}}
                                            </div>

                                        </td>
                                        <td>
                                            <div class="form-group form-float">
                                                {{form::submit('Add new', ['class' => 'btn btn-primary'])}}
                                            </div>
                                        </td>
                                        {{ Form::close() }}
                                    </tr>
                                    <!-- Adding new line -->

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- #END# Exportable Table -->



    </div>