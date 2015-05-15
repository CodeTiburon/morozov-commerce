<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id', 'name', 'telephone', 'shipping_address', 'payment_method_id', 'order_status_id'];

    public function products()
    {
        return $this->belongsToMany('App\Models\OrderProduct', 'order_product');
    }

}
