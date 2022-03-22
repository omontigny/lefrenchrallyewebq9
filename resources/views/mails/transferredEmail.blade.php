{{-- this mails is unactivated and not sent anymore  --}}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear {{$application->parentfirstname}},</p>

        <p>We are pleased to welcome {{$application->childfirstname}} to Rallye {{$application->rallye->title}}. The registration will only be complete once the Rallye membership is paid. To pay for the membership immediately, please use the link below:
        <a href="{{$paymentLink}}">{{$paymentLink}}</a>

        <p>All member-related information can be found under the "Member" tab on the website (<a href="{{$officialLink}}">{{$officialLink}}</a>) once you have logged in.</p>

        <p>Looking forward to meeting you and your children,</p>

        <p>Kind regards,</p>

        <p>The Rallye {{$application->rallye->title}} Coordinators</p>
</body>
</html>
