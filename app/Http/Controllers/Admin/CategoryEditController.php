<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Validator;
use Illuminate\Http\Request;

class CategoryEditController extends Controller {

    /**
     * @param Registrar $registrar
     */
    public function __construct(Registrar $registrar)
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories =  Category::all()->toHierarchy();
        return view('admin/categories/edit_all', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $validator = \MyAuth::checkCategoryField($request->only('name')['name']);

        if($validator->passes()){
            if($request['selected_type'] === 'root'){
                // add the new root category
                $node = Category::create(['name' => $request->only('name')['name']]);
            } else if($request['selected_type'] === 'flat'){
                // add the category to the current level
                $node = Category::where('id', '=', $request['category_id'])->first();
                $child = Category::create(['name' => $request->only('name')['name']]);
                $child->makeSiblingOf($node);
            } else if($request['selected_type'] === 'child'){
                // add the category to the current node as a child
                $node = Category::where('id', '=', $request['category_id'])->first();
                $child = Category::create(['name' => $request->only('name')['name']]);
                $child->makeChildOf($node);
            } else{
                $node = 'error';
            }
            $json = array();
            $json['tree'] = $node;
        } else {
            $json['errors'] = $validator->messages();
        }

        return response()->json($json);
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request)
    {
        $json = array();
        $node = Category::where('id', '=', $request['category_id'])->first();
        if($node){
            $node->delete();
            $json['success'] = true;
        } else {
            $json['error'] = 'Removing error';
        }

        return response()->json($json);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
