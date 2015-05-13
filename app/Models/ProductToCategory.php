<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToCategory extends Model {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_to_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'category_id'];


}
