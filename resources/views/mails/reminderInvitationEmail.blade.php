<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
<p>Dear Parents of <b>{{$checkin->childfirstname}}<b>,</p>
<p>This is a reminder to please reply to the invitation below as soon as possible, otherwise your child will be marked as "Not attending" and will not be on the guest list for the event. You can view the invitation below.</p>
<p>To respond to the invitation, connect on your member area on <a href="{{$domainLink}}">{{$domainLink}}</a> then go to “Member/My invitations” tab.</p>

<img src="{{  $message->embed(public_path('/assets/images/invitations/'. $imageName)) }}">

<section>
<div align="center">
  <p> If you don't visualize the attached image you can use the following <a href="{{ $image_url }}" class="btn btn-default float-right" >link</a></p>
</div>

<p>Kind regards,</p>

<p>The Host Parents</p>


</body>
</html>
