<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductToCategory;
use Illuminate\Pagination\Paginator;
use Input;
use Validator;
use Redirect;
use Session;

class ProductController extends Controller
{

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
        $productsAll = Product::paginate(10);

        foreach ($productsAll as $product) {
            $image = $product->images()->where('id', '=', $product->primary_image_id)->first();
            $products[] = array(
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->quantity,
                'price' => $product->price,
                'model' => $product->model,
                'image' => isset($image->image) ? $image->image : 'no_image.png',
                'description' => $product->description,
                'created_at' => \Carbon::parse($product->created_at)->toFormattedDateString(),
            );
        }

        return view('admin/products/products', ['products' => isset($products) ? $products : null, 'plinks' => $productsAll->render()]);

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
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
