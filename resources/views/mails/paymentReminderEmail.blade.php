<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear {{$application->parentfirstname}}</p>

<p>This is a reminder that your application for {{$application->childfirstname}} to Rallye {{$application->rallye->title}} will not be accepted until you have paid. To pay for the application please use the following link:
<a href="{{$paymentLink}}">{{$paymentLink}}</a></p>

<p>Kind regards,</p>
