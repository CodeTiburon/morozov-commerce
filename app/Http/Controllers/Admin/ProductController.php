<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Input;
use Validator;
use Redirect;
use Session;
class ProductController extends Controller {

    /**
     * @param Registrar $registrar
     */
    public function __construct(Registrar $registrar)
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $categories =  Category::getNestedList('name', null , $seperator = '&#8212;');
        if(\MyAuth::isAdmin()) {
            return view('admin/products/add_product', ['categories' => $categories]);
        } else {
            return "No-no-no, you are not an Admin";
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
        // getting all of the post data
        $files = Input::file('images');
        // Making counting of uploaded images
        $file_count = count($files);
        // start count how many uploaded
        $data = \MyHelpers::imagesUpload($files);
        $uploadcount = $data['count'];
        $validator = $data['validator'];
        if(true){
            $productId = Product::create([
                'name' => $request['name'],
                'model' => $request['model'],
                'description' => $request['description'],
                'quantity' => $request['quantity']
            ]);

            ProductImage::create([
                'product_id' => $productId->id,
                'image' => '/ololo/nanana'
            ]);
            dd($productId->id);
        }
        if($uploadcount == $file_count){
            Session::flash('success', 'Upload successfully');
            return Redirect::to('/admin/products/add');
        }
        else {
            return Redirect::to('/admin/products/add')->withInput()->withErrors($validator);
        }
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
