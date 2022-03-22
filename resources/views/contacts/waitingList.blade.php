<div class="col-xs-12">
    <h4><span class="glyphicon glyphicon-user"></span> Waiting list</h4>
    <hr>
    @if(count($waitingList) > 0)
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Waiting list</strong> ({{count($waitingList)}})</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table dataTable js-exportable">
                                <!--<table class="table table-bordered table-striped table-hover dataTable js-exportable">-->
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Child</th>
                                        <th>School</th>
                                        <th>Parent</th>
                                        <th>Email</th>
                                        <th>Home</th>
                                        <th>Mobile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($waitingList as $row)
                                    <tr>
                                        <td><strong>{{$row->id}}</strong></td>
                                        <td><strong>{{$row->childlastname}} {{$row->childfirstname}}</strong></td>
                                        <td><strong>{{$row->school->name}}</strong></td>
                                        <td><strong>{{$row->parentlastname}} {{$row->parentfirstname}}</strong></td>
                                        <td><strong><a
                                                    href="mailto:{{$row->parentemail}}">{{$row->parentemail}}</a></strong>
                                        </td>
                                        <td><strong><a href="tel:{{$row->parenthomephone}}">{{$row->parenthomephone}}</a></strong>
                                        </td>
                                        <td><strong><a
                                                    href="sms:{{$row->parentmobile}}">{{$row->parentmobile}}</a></strong>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- #END# Exportable Table -->
    </div>

    @else
    <p class="text-danger"><b>Nobody currently has received a special access.</b></p>
    @endif
   </div>