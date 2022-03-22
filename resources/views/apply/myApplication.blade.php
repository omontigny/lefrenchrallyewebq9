<div class="col-xs-12">
    @if(count($applications) > 0)
    <h4><span class="glyphicon glyphicon-file"></span> My applications</h4>
    <hr>


    <div class="container-fluid">

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Resume</strong> your application</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table dataTable js-exportable">
                                <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Child first name</th>
                                        <th>Your Email</th>
                                        <th style="width:40px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Adding new line -->
                                    <tr>
                                        {{ Form::open(['action' => 'ApplicationRequestsExtraController@GetChildApplication', 'method' => 'POST']) }}
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <td>
                                            <div class="form-group form-float">
                                                {{form::text('childfirstname', '', ['class' => 'form-control', 'placeholder' => 'User name'])}}
                                            </div>

                                        </td>
                                        <td>

                                            <div class="form-group form-float">
                                                {{form::text('parentemail', '', ['class' => 'form-control', 'placeholder' => 'email'])}}
                                            </div>

                                        </td>
                                        <td>
                                            <div class="form-group form-float">
                                                {{form::submit('Check', ['class' => 'btn btn-primary'])}}
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
        @endif



    </div>