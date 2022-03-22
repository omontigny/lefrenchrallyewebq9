<div class="col-xs-12">
        
    <!-- TODO: if I can see this rallyes-->
        <h4><span class="glyphicon glyphicon-user"></span> Working</h4>
        <hr>
        @if(count($membersByRallye) > 0)
            @foreach($membersByRallye as $rallye)
            <a href="mailto:?bcc=
            @foreach ($parentGroups as $parentGroup)@if ($parentGroup->group->rallye->id == $rallye->id){{$parentGroup->parent->parentemail}},@endif @endforeach"><button type="button" class="btn btn-primary btn-md">{{$rallye->title}} ({{$rallye->nbMembers}})</button></a>
       
            
            @endforeach

        @else
        <p class="text-danger"><b>Nobody currently has received a special access.</b></p>
        @endif
    <!-- TODO: if I can see this rallyes -->

        <h4><span class="glyphicon glyphicon-user"></span> Event groups</h4>
        <hr>
        @if(count($membersByEvent) > 0)
            @foreach($membersByEvent as $group)
            <a href="mailto:?bcc=@foreach ($parentGroups as $parentGroup)@if ($parentGroup->group_id == $group->id){{$parentGroup->parent->parentemail}},@endif @endforeach"><button type="button" class="btn btn-primary btn-md">{{$group->name}} ({{$group->nbMembers}})</button></a>
       
            
            @endforeach

        @else
        <p class="text-danger"><b>Nobody currently has received a special access.</b></p>
        @endif
        <div class="container-fluid">
           
    
        </div>

        