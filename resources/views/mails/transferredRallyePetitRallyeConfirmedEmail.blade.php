{{-- this mails is not used  --}}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
<p>Dear [name of parent] {{$invitation->group->rallye->title}},</p>

<p>We are pleased to confirm the membership of [name of child] for Rallye [name of rallye]. We will send shortly information about your group members and the date of the event you will be organising</p>

<p>All member-related information can be found under the "Member" tab on the website (<a href="{{$officialLink}}">{{$officialLink}}</a>) once you have logged in (members of your Rallye, contact details for other parents, invitations to events, your event, guest list…).</p>

<p>Looking forward to meeting you and your children,</p>

<p>Kind regards,</p>

<p>The Rallye {{$application->rallye->title}} Coordinators</p>

</body>
</html>
