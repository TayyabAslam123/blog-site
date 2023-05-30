<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;
use Session;
use Exception;

class SiteController extends Controller
{
    private $redirect_url = 'sites';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Sites';
        $headings = ["url"=>"Title","is_category" => "Is Category","is_post" => "Is Post","last_page"=>"Last Pg#",
        "created_at" => "Created At","updated_at" => "Updated At"];
        
        $url = "sites";
        $disable_edit = true;


        $values = Site::orderby('id','DESC')->get();;
        $data = [
            ['name'=>'URL', "type"=>"text", "attrib"=>'required="required" name="url" maxlength="299"']
        ];
        
        return view('admin.index', compact('title', 'headings', 'values', 'url', 'data', 'disable_edit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            Site::create([
                'url' => $request->url
            ]);
            Session::flash('message', 'Added Successfully !');
            Session::flash('alert-class', 'alert-success');
            return redirect($this->redirect_url);
        } catch (Exception $e) {
               Session::flash('message', $e->getMessage());
               Session::flash('alert-class', 'alert-danger');
               return redirect($this->redirect_url);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        try{
            $site->delete();
            Session::flash('message', 'Deleted Successfully !');
            Session::flash('alert-class', 'alert-success'); 
            return redirect($this->redirect_url);
        }catch(Exception $e){
            Session::flash('message', $e->getMessage());
            Session::flash('alert-class', 'alert-danger'); 
            return redirect($this->redirect_url);
        }
    }
}
