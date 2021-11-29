<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticSites;

class StaticSitesController extends Controller
{
    public function index()
    {
        $staticsites = StaticSites::paginate(15);
        return view('dashboard.staticsites.index', ['staticsites' => $staticsites]);
    }

    public function edit($id)
    {
        $staticsites = StaticSites::where('id', $id)->first();
        return view('dashboard.staticsites.edit')->with(['staticsites' => $staticsites]);
    }

    public function update(Request $request, $id)
    {
        $staticsites = StaticSites::where('id', $id)->first();
        $staticsites->name = $request->name;
        $staticsites->content = $request->content;
        $staticsites->save();

        return redirect()->route('dashboard.staticsites.index');
    }
}
