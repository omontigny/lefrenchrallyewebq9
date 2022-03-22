<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
<p>Dear Parents of {{$checkin->childfirstname}},</p>
<p>This is a reminder to please reply to the invitation below as soon as possible, otherwise your child will be marked as "Not attending" and will not be on the guest list for the event. You can view the invitation below.</p>
<p>To respond to the invitation, connect on your member area on <a href="{{$domainLink}}">{{$domainLink}}</a> then go to “Member/My invitations” tab.</p>

<img src={{$invitationFile}} alt="invitationFile" />

<p>Kind regards,</p>

<p>The Host Parents</p>


</body>
</html>
