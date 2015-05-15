<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\MyHelpers;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductToCategory;
use DB;
use Input;
use Validator;
use Redirect;
use Session;


class CartController extends Controller {

    protected $cart;

    /**
     * @param Registrar $registrar
     */
    public function __construct(Registrar $registrar)
    {
        //$this->middleware('auth');
        $this->cart = Session::get('cart');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(MyHelpers $cart)
	{
        $products = $cart->cartProducts();
        return view('cart', ['cart' => $cart, 'products' => isset($products) ? $products : null]);
    }

    function postAdd(Request $request)
    {
        $id = $request['id'];

        if (Session::has('cart.'.$id))
        {
            $quantity = Session::get('cart.'.$id);
            ++$quantity;
            Session::put('cart.'.$id, $quantity);
        }
        else
        {
            Session::put('cart.'.$id, 1);
        }

        if ($id){
            $json['id'] = $id;
            return response()->json($json);
        }
    }

    function postQtyUpdate(Request $request)
    {
        $id = $request['product_id'];
        $newQuantity = (int)$request['quantity'];
        if ($newQuantity > 0){
            Session::put('cart.'.$id, $newQuantity);
        } else {
            $this->ClearProduct($id);
        }

        $json['id'] = $id;

        return response()->json($json);
    }

    function postClear()
    {
        foreach( Session::get('cart') as $id => $qty)
        {
            Session::forget('cart.'.$id);
        }

        $json['success'] = true;

        return response()->json($json);
    }

    function postClearProduct(Request $request)
    {
        $this->ClearProduct($request['product_id']);
        $json['id'] = $request['product_id'];

        return response()->json($json);
    }

    function ClearProduct($id)
    {
        Session::forget('cart.'.$id);
    }

    static function postTotalItems(MyHelpers $cart)
    {
        $json = array();

        $json['total_items'] = $cart->cartTotalItems();

        return response()->json($json);
    }

    function postTotalSum(MyHelpers $cart)
    {
        $json = array();

        $json['total_sum'] = $cart->cartTotalSum();

        return response()->json($json);
    }





}
