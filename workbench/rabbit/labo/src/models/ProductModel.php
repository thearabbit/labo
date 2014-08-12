<?php
namespace Rabbit\Labo;

class ProductModel extends \Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product';

    public function productChildren()
    {
        $this->hasMany('Rabbit\Labo\ProductChildModel', 'product_id');
    }

}
