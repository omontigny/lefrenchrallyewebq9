@if($activeRallye != null)
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">

            @if(Auth::user()->admin != 0 || Auth::user()->coordinator != 0 || Auth::user()->parent != 0)
                <p class="text-center">
                <span class="text-dark font-weight-bold">Active profile:</span><span
                    class="text-info font-weight-bold"> {{Auth::user()->active_profile}}</span>
                @endif
                | <span class="text-dark font-weight-bold">ACTIVE RALLYE: </span><span
                    class="text-success font-weight-bold">{{$activeRallye}}</span></p>
            </div>
        </div>
    </div>

    @endif