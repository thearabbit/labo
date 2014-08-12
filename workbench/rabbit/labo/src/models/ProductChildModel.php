<?php
namespace Rabbit\Labo;

class ProductChildModel extends \Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_child';

    public function product()
    {
        return $this->belongsTo('Rabbit\Labo\ProductModel');
    }
}
