<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MyHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\User;
use App\Models\ProductToCategory;
use DB;
use Input;
use Validator;
use Redirect;
use Session;


class CheckoutController extends Controller {

    protected $cart;

    /**
     * @param Registrar $registrar
     */
    public function __construct(Registrar $registrar)
    {
        $this->middleware('auth');
        $this->cart = Session::get('cart');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(MyHelpers $cart)
	{

        return view('checkout', ['cart' => $cart]);
    }

    function postMakeOrder(Request $request, MyHelpers $cart)
    {
        $json = array();
//dd($request->all());
        $order = Order::create($request->all());
        $products = $cart->cartProducts();
        foreach ($products as $product) {
            $order->products()->attach($product['id'], array('quantity' => $product['quantity'], 'total_price' => $product['price_total'], 'created_at' => $product['created_at']));
        }

        $json['total_sum'] = 0;

        return response()->json($json);
    }





}
