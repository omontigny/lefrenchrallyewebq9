<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear {{$coordinator->firstname}},</p>

        <p>Your password has been set/changed, please sign in with the following one.</p>

        <p>Your new password is: <span><b>{{$userPassword}}</b></span></p>

        <p>Kind regards</p>

        <p>Le French Rallye</p>

</body>
</html>
