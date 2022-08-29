<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear {{$application->parentfirstname}},</p>

        <p>Your password has been changed, please sign in with the following one.</p>

        <p>Your password is: <span><b>{{$userPassword}}</b></span></p>

        <p>Kind regards</p>

        <p>The {{$application->rallye->title}} Coordinators</p>

</body>
</html>
