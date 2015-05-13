<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductToCategory;
use Input;
use Validator;
use Redirect;
use Session;
use app\Services\MyAuth;
class ProductAddController extends Controller {

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
        //$categories =  Category::getNestedList('name', null , $seperator = '&#8212;');
        $categories =  Category::all()->toHierarchy();

        return view('admin/products/add_product', ['categories' => $categories]);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
    public function create(Request $request, MyAuth $auth)
	{
        // getting all of the post data
        $files = Input::file('images');
        // Making counting of uploaded images
        $file_count = count($files);
        //dd($files);
        $validatorData = array('file' => $files[0] ?: null, 'name' => $request->only('name')['name']);
        $validator = $auth->checkProductField($validatorData);
        if ($validator->passes()){
            $product = Product::create($request->all());
            $product->categories()->attach($request['category']);
            // start count how many uploaded
            if($files[0]){
                $imgUploadData = \MyHelpers::imagesUpload($files);
                $uploadcount = $imgUploadData['count'];
                $primaryImgPosition = 1;
                foreach ($imgUploadData['images'] as $image) {
                    $imageData = ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $image
                    ]);
                    if ($primaryImgPosition == $request['primary-image']){
                        $product = Product::find($product->id);
                        $product->primary_image_id = $imageData->id;
                        $product->save();
                    }
                    $primaryImgPosition++;
                }
            }
        }

        if((isset($uploadcount) && $uploadcount != $file_count) || $validator->fails()) {
            $json['errors'] = $validator->messages();
            // return Redirect::to('/admin/products/add')->withInput()->withErrors($validator);
        }
        else {
            Session::flash('success', 'Upload successfully');
            //return Redirect::to('/admin/products');
            $json['redirect_url'] = url('/admin/products');
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
