<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        <p>Dear {{$recipient}},</p>
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif

        <p><strong>Mail sent to test email feature in Admin Control Panel</strong> <br/>
             Please click on the link below to be redirected to the Apply Page:<a href="{{$domainLink}}/apply">{{$domainLink}}/apply</a> </p>

<p>See you,</p>
<p>{{$recipient}}</p>

</body>
</html>
