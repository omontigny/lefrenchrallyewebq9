<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Models\Coordinator;
use App\Models\Admin_Rallye;
use App\Models\Coordinator_Rallye;
use App\Models\Parents;
use App\Models\Parent_Rallye;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);

        //compose all the views....
        

        view()->composer('*', function ($view) 
        {
            $activeRallye = '';
            if(Auth::user() != null)
            {
                if(Auth::user()->active_profile == config('constants.roles.SUPERADMIN'))
                {
                    $adminRallye = Admin_Rallye::where('user_id', Auth::user()->id)->where('active_rallye', '1')->first();
                    if($adminRallye != null)
                    {
                        $activeRallye = $adminRallye->rallye->title;
                    }
                }
                elseif(Auth::user()->active_profile == config('constants.roles.COORDINATOR'))
                {
                    $coordinator = Coordinator::where('user_id', Auth::user()->id)->first();
                    $coordinatorRallye = Coordinator_Rallye::where('coordinator_id', $coordinator->id)->where('active_rallye', '1')->first();
                    if($coordinatorRallye != null)
                    {
                        $activeRallye = $coordinatorRallye->rallye->title;
                    }
                }elseif(Auth::user()->active_profile == config('constants.roles.PARENT'))
                {   
                    $parent = Parents::where('user_id', Auth::user()->id)->first();
                    $parentRallye = Parent_Rallye::where('parent_id', $parent->id)->where('active_rallye', '1')->first();
                    if($parentRallye != null)
                    {
                        $activeRallye = $parentRallye->rallye->title;
                    }
                }
                
            }
            
            
            View::share('activeRallye', $activeRallye);
        }); 

    }
}
