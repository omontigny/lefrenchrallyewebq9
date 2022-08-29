<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>
        @section('content')
        @if($_ENV['APP_ENV'] != 'prod')
          <h2><font color='orange'>!! CECI EST UN TEST NE PAS TENIR COMPTE !!</font></h2>
        @endif
        <p>Dear {{ucfirst($application->parentfirstname)}},</p>

        <p>We are pleased to welcome {{$application->childfirstname}} to {{$application->rallye->title}}. The
                registration will only be complete once the Rallye membership is paid. To pay for the membership
                immediately, please use the link below:</p>
        <ol>
        <li>Once your received your child's application acceptance email, go to the following payment link: <a href="{{$paymentLink}}">{{$paymentLink}}</a></li>
                <li>Fill in the form</li>
                <li>The website will display your form search results</li>
                <li>Click on the Pay button and enter your card information, then click on the Pay button</li>
                <li>You will be redirected to the confirmation payment page, and you will receive an email as proof of your transaction</li>
        </ol>

        <p>All member-related information can be found under the "Member" tab on the website (<a href="{{$domainLink}}">{{$domainLink}}</a>) once you have logged in.</p>

        <p>Looking forward to meeting you and your child,</p>

        <p>Kind regards,</p>

        <p>The {{$application->rallye->title}} Coordinators</p>
</body>

</html>
