<?php
namespace Rabbit\Labo;

use Laracasts\Presenter\PresentableTrait;

class StaffModel extends \Eloquent
{
    use PresentableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'staff';

    /*
     * Presenter
     */
    protected $presenter = 'Rabbit\Labo\Presenters\StaffPresenter';

    /**
     * Relation with invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('InvoiceModel', 'staff_id');
    }
}
