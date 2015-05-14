<?php namespace App\Services;

use Validator;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class MyHelpers {

    public static function imagesUpload($files, $imageSize = 1024, $imageEncodeTo = 'png', $saveOriginal = false, $preventUpsize = true) {
        // start count how many uploaded
        $uploadcount = 0;
        $imagesArr = array();
        $path = base_path().'/public/uploads/';
        foreach($files as $file) {
            $image = \Image::make($file);
            //make prefix
            $imagePrefix = date('Y-m-d-H:i:s')."-".$file->getClientOriginalName();
            // encode image to png
            $image->encode($imageEncodeTo);
            // save original
            if($saveOriginal){
                $image->save($path.$imagePrefix."_original.png");
            }
            //resize
            $image->resize(null, $imageSize, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            // save resized
            $imgName = $imagePrefix."_resized.png";
            $image->save($path.$imgName);
            $imagesArr[] = $imgName;
            $uploadcount ++;
        }
        return Array('count' => $uploadcount, 'path' => $path, 'images' => $imagesArr);
    }

    public function categoriesSeed()
    {
        $categories = [
            ['id' => 1, 'name' => 'TV & Home Theather'],
            ['id' => 2, 'name' => 'Tablets & E-Readers'],
            ['id' => 3, 'name' => 'Computers', 'children' => [
                ['id' => 4, 'name' => 'Laptops', 'children' => [
                    ['id' => 5, 'name' => 'PC Laptops'],
                    ['id' => 6, 'name' => 'Macbooks (Air/Pro)']
                ]],
                ['id' => 7, 'name' => 'Desktops', 'children' => [
                    // These will be created
                    ['name' => 'Towers Only'],
                    ['name' => 'Desktop Packages'],
                    ['name' => 'All-in-One Computers'],
                    ['name' => 'Gaming Desktops']
                ]]
                // This one, as it's not present, will be deleted
                // ['id' => 8, 'name' => 'Monitors'],
            ]],
            ['id' => 9, 'name' => 'Cell Phones']
        ];

        Category::buildTree($categories); // => true
    }

    public function cartTotalItems()
    {
        $cart = Session::get('cart');
        $num_items = 0;

        if(is_array($cart))
        {
            foreach($cart as $id => $qty)
            {
                $num_items = $num_items + $qty;
            }
        }

        return $num_items;
    }

    public function cartTotalSum()
    {
        $cart = Session::get('cart');

        $total_price = 0;
        $sales = 1;

        if(is_array($cart))
        {
            $products = $this->cartProducts();

            foreach($products as $product )
            {
                if($product)
                {
                    $item_price = $product['price'];
                    $quantity = $cart[$product['id']];
                    $total_price = ($total_price + $item_price * $quantity) * $sales;
                }
            }
        }
        return $total_price;
    }

    public function cartTotalProductSum(){
        $cart = Session::get('cart');

    }

    public function cartProducts(){
        $cart = Session::get('cart');
        $productsInCart = Product::whereIn('id',  array_keys($cart))->get();
        $products = array();
        foreach ($productsInCart as $product) {
            $products[] = $this->cartProductData($product);
        }
        return $products;
    }

    public function cartProductData($productObj){
        $cart = Session::get('cart');

        $image = $productObj->images()->where('id', '=', $productObj->primary_image_id)->first();
        return array(
            'id' => $productObj->id,
            'name' => $productObj->name,
            'quantity' => $cart[$productObj->id],
            'price' => $productObj->price,
            'price_total' => $productObj->price * $cart[$productObj->id],
            'model' => $productObj->model,
            'image' => isset($image->image) ? $image->image : 'no_image.png',
            'description' => $productObj->description,
            'created_at' => \Carbon::parse($productObj->created_at)->toFormattedDateString(),
        );

    }

}
