<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
         @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear {{$application->parentfirstname}},</p>

        <p>We regret to inform you that we are not able to accept {{$application->childfirstname}} in the {{$application->rallye->title}} at the moment.</p>

        <p>We will keep your application in the waiting list and will of course get in touch with you should a place become available in the future.</p>

        <p>Kind regards,</p>

        <p>The {{$application->rallye->title}} Coordinators</p>
</body>
</html>
