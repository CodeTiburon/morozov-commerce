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
use File;
class ProductEditController extends Controller {

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
            'model' => $productQuery->model,
            'price' => $productQuery->price,
            'description' => $productQuery->description,
            'categories' => $categoriesId,
            'quantity' => $productQuery->quantity,
            'image' => isset($image->image) ? $image->image : 'no_image.png',
            'thumbs' => $productQuery->images()->where('id', '<>', $productQuery->primary_image_id)->orderBy('order')->get(),
        );

        return view('admin/products/edit_product', ['categories' => $categories, 'product' => $product]);


	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request, $id = null)
	{
        $json = array();
        $validator = \MyAuth::checkProductField(array('file' => null, 'name' => $request->only('name')['name']));

        if ($validator->passes()) {
            // start count how many uploaded
            $product = Product::find($request['id']);
            if($request['category']){
                $product->categories()->sync($request['category']);
            }

            if(isset($request['images_order'])){
                $imagesOrderArray = $request['images_order'];
                foreach ($imagesOrderArray as $imageOrder => $imageId) {
                    $img = $product->images()->find($imageId);
                    $img->order = $imageOrder;
                    $img->save();
                }
            }
            $product->update($request->all());
            $json['redirect_url'] = url('/admin/products');
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
        $product = Product::find($request['product_id']);

        if($product->images()){
            $images = $product->images()->get();
            foreach ($images as $image) {
                File::delete(public_path().'/uploads/'.$image->image);
            }
        }
        $product->categories()->detach();
        $product->images()->delete();
        $product->delete();

        if($product){
            $json['success'] = true;
            $json['redirect_url'] = url('/admin/products');
        } else {
            $json['error'] = 'Removing error';
        }

        return response()->json($json);
    }

}
