<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear Parents of [name of child],</p>
        <br />
        <p>[child first name] is invited to a <b>{{$invitation->group->rallye->title}}<b> event on @if($invitation->group->eventDate != null)
        <b>{{\Carbon\Carbon::parse($invitation->group->eventDate)->format('d-m-Y')}}</b>
        @else
          'Unknown Invitation Date'
        @endif . You can view the invitation below.</p>

        <p>Please reply as soon as possible before the deadline and in accordance with the instructions indicated in the invitation</p>

        <p>To respond to the invitation, connect on your member area on <a href="{{$domainLink}}">{{$domainLink}}</a> then go to “Member/My invitations” tab. </p>

        <img src="{{  $message->embed(public_path('/assets/images/invitations/'. $imageName)) }}">

        <section>
        <div align="center">
          <p> If you don't visualize the attached image you can use the following <a href="{{ $cloudinaryImageUrl }}" class="btn btn-default float-right" >link</a></p>
        </div>

        <br>

        <p>Kind regards,</p>

        <p>The Host Parents</p>

</body>
</html>
