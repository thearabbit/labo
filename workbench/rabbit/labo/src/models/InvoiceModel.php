<?php
namespace Rabbit\Labo;

class InvoiceModel extends \Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invoice';

    public function staff()
    {
        return $this->belongsTo('StaffModel');
    }
}
