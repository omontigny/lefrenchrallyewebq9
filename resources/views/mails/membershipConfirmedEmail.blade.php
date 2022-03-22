<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
<p>Dear {{$application->parentfirstname}},</p>

<p>We are pleased to confirm the membership of {{$application->childfirstname}} for Rallye {{$application->rallye->title}}. We will send shortly information about your group members and the date of the event you will be organising</p>

<p>All member-related information can be found under the "Member" tab on the website (<a href="{{$domainLink}}">{{$domainLink}}</a>) once you have logged in (members of your Rallye, contact details for other parents, invitations to events, your event, guest list…).</p>

@if($userPassword != '')
<p>Your password is: <span><b>{{$userPassword}}</b></span></p>
<p>Please keep this password safe as you will need it every time you connect to the member area of the website. If you lose your password please contact your Rallye coordinator to reset your password.</p>
@else
<p>Note: Use your current password.</b></span></p>
@endif

<p>Looking forward to meeting you and your child,</p>

<p>Kind regards,</p>

<p>The Rallye {{$application->rallye->title}} Coordinators</p>




</body>
</htl>
