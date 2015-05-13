<?php namespace App\Http\Controllers;

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
	public function index($id)
	{
        $categories =  Category::all()->toHierarchy();
        $productQuery =  Product::find($id);
        $categoriesId = array();

        foreach ($productQuery->categories()->get() as $categoryId) {
            $categoriesId[] = $categoryId->id;
        }

        $image = $productQuery->images()->where('id', '=', $productQuery->primary_image_id)->first();
        $product = array(
            'id' => $productQuery->id,
            'image_id' => isset($image->id) ? $image->id : 1,
            'name' => $productQuery->name,
            'price' => $productQuery->price.' $',
            'model' => $productQuery->model,
            'description' => $productQuery->description,
            'categories' => $categoriesId,
            'quantity' => $productQuery->quantity,
            'image' => isset($image->image) ? $image->image : 'no_image.png',
            'thumbs' => $productQuery->images()->where('id', '<>', $productQuery->primary_image_id)->get(),
        );

        if(\MyAuth::isAdmin()) {
            return view('product', ['categories' => $categories, 'product' => $product]);
        } else {
            return "No-no-no, you are not an Admin";
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
