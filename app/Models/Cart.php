<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'quantity', 'model', 'price', 'primary_image_id'];

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_to_category');
    }

    public function cartProducts($array){
        //
    }

}
