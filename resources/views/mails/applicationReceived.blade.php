<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear {{$application->parentfirstname}},</p>

        <p>We received your application for {{$application->childfirstname}}’s membership for Rallye {{$application->rallye->title}}.</p>

        <p>Confirmation of the membership will be sent within a month.</p>

        <p>Kind regards</p>

        <p>The Rallye {{$application->rallye->title}} Coordinators</p>

</body>
</html>
