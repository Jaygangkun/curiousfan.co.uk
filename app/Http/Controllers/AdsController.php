<?php

namespace App\Http\Controllers;

use App\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $advertisements = Ads::all();
        return view('admin.ads_list')
            ->with('type', 'add')
            ->with('active', 'ads')
            ->with('advertisements', $advertisements);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ads_add')
            ->with('type', 'create')
            ->with('active', 'ads');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            'ad_provider' => 'required',
            'ad_script'      => 'required',
            'ad_status'      => 'required'
        ]);
        
        $e = new Ads;
        $e->ad_provider = $request->ad_provider;
        $e->ad_script = htmlspecialchars($request->ad_script);
        $e->ad_status = $request->ad_status;
        $e->save();
        return redirect('admin/ads')->with('msg', 'Ads successfully created.');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertisement = Ads::find($id);
        return view('admin.ads_edit')
            ->with('type', 'create')
            ->with('active', 'ads')
            ->with('advertisement', $advertisement);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ad_provider' => 'required',
            'ad_script'      => 'required',
            'ad_status'      => 'required'
        ]);
        $e = Ads::find($id);
        $e->ad_provider = $request->ad_provider;
        $e->ad_script = htmlspecialchars($request->ad_script);
        $e->ad_status = $request->ad_status;
        $e->save();
        return redirect('admin/ads')->with('msg', 'Ads successfully saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $e = Ads::find($id);
        $e->delete();
        return redirect('admin/ads')->with('msg', 'Ads deleted.');
    }
    
}
