<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller {

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
        /** @var  $productsAll */
        $productsAll = Category::find($id)->products()->get();

        /** @var array $products */
        $products = array();

        foreach ($productsAll as $product) {
            /** @var Product $product */
            $image = $product->images()->where('id', '=', $product->primary_image_id)->first();
            $products[] = array(
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->quantity,
                'model' => $product->model,
                'image' => isset($image->image) ? $image->image : 'no_image.png',
                'description' => $product->description,
                'created_at' => \Carbon::parse($product->created_at)->toFormattedDateString(),
            );
        }

        if(\MyAuth::isAdmin()) {
            return view('category', ['categories' => $categories, 'products' => $products]);
        } else {
            return "No-no-no, you are not an Admin";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function products(Request $request)
    {
        $json = array();

        /** @var array $products */
        $products = array();

        /** @var  $productsAll */
        $productsAll = Category::find($request['id'])->products()->get();

        if ($productsAll){
            foreach ($productsAll as $product) {
                /** @var Product $product */
                $image = $product->images()->where('id', '=', $product->primary_image_id)->first();
                $products[] = array(
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $product->quantity,
                    'model' => $product->model,
                    'image' => isset($image->image) ? asset('uploads/'.$image->image ) : asset('uploads/no_image.png'),
                    'description' => $product->description,
                    'short_descr' => $product->description ? substr($product->description, 0, 25).' ...' : ' ',
                    'created_at' => \Carbon::parse($product->created_at)->toFormattedDateString(),
                );
            }

            $json['products'] = $products;
        } else {
            $json['errors'] = 'error';
        }

        return response()->json($json);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
    public function editAll()
    {
        return view('admin/categories/edit_all', ['name' => 'James']);
    }


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
