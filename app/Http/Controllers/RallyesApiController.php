<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rallye;
use App\Models\Admin_Rallye;
use App\Models\Coordinator_Rallye;

class RallyesApiController extends Controller
{
    public function index()
    {
        return Rallye::all();
    }
 
    public function show($id)
    {
        return Rallye::find($id);
    }

    public function store(Request $request)
    {
        return Rallye::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $rallye = Rallye::findOrFail($id);
        $rallye->update($request->all());

        return $rallye;
    }

    public function delete(Request $request, $id)
    {
        $rallye = Rallye::findOrFail($id);
        Admin_Rallye::where('rallye_id', $rallye->id)->delete();
        Coordinator_Rallye::where('rallye_id', $rallye->delete());
        $rallye->delete();

        return 204;
    }

}
