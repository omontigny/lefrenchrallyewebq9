<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        <p>Dear {{$recipient}},</p>
        @if(env('APP_ENV') != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p><strong>You have been given special access to apply on the Rallye Website.</strong> <br/>
             Please click on the link below to be redirected to the Apply Page:<a href="{{$domainLink}}/apply">{{$domainLink}}/apply</a> </p>

<p>See you,</p>
<p>{{$recipient}}</p>

</body>
</html>
