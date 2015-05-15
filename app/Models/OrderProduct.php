<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'product_id', 'quantity', 'total_price'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Order');
    }

}
