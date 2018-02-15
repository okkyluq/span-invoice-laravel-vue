<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';
    protected $primaryKey = 'id';
    protected $fillable = ['invoice_no','client','client_address','tittle','invoice_date','sub_total','discount','grand_total','grand_total'];

    public function products()
    {
    	return $this->hasMany(InvoiceProduct::class);
    }
 
}
