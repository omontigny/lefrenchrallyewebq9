<div class="col-xs-12">
@if(Auth::user()->active_profile == Config::get('constants.roles.SUPERADMIN'))

  <h4><span class="glyphicon glyphicon-info-sign"></span> Versions </h4>
    <hr>
  <p>Laravel : {{ app()->version() }}</p>
  <p>PHP :  {{phpversion()}}</p>
  <p>Node : {{exec('node -v')}}
 </p>


@endif


