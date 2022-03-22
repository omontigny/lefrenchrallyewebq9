<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
<p>Dear Parents of {{$application->childfirstname}},</p>

<p>{{ucfirst($application->childfirstname)}} is invited to a {{$application->rallye->title}} event on @if($invitation->group->eventDate != null)
{{\Carbon\Carbon::parse($invitation->group->eventDate)->format('d-m-Y')}}
@else
  'Unknown Invitation Date'
@endif . You can view the invitation below.</p>

<p>Please reply as soon as possible before the deadline and in accordance with the instructions indicated in the invitation</p>

<p>To respond to the invitation, connect on your member area on <a href="{{$domainLink}}">{{$domainLink}}</a> then go to “Member/My invitations” tab. </p>

<img src={{$invitationFile}} alt="invitationFile" />

<p>Kind regards,</p>

<p>The Host Parents</p>

</body>
</html>
