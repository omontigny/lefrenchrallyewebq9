<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear {{$application->parentfirstname}},</p>

        <p>Thank you for your payment about the membership of {{$application->childfirstname}} for Rallye {{$application->rallye->title}}.</p>

        <p>Our team will check your payment and send you an email in few days with your authentification infos.</p>

        <p>Kind regards</p>

        <p>The Rallye {{$application->rallye->title}} Coordinators</p>

</body>
</html>
