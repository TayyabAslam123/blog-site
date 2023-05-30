<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use Session;
use Exception;

class CategoryController extends Controller
{
    private $redirect_url = 'categories';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title='Categories';
        $headings = ["name"=>"Name","slug" => "Slug","cat_id"=>"Category-Id","status" => "Status",
        "created_at" => "Created At","updated_at" => "Updated At"];
        
        $url = "categories";
        $values = Category::orderby('id','DESC')->get();
        $data = [
            ['name'=>'Name', "type"=>"text", "attrib"=>'required="required" name="name" maxlength="299"'],
            ['name'=>'Slug', "type"=>"text", "attrib"=>'required="required" name="slug" maxlength="299"']
        ];
        
        return view('admin.index', compact('title', 'headings', 'values', 'url', 'data'));
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
            Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
