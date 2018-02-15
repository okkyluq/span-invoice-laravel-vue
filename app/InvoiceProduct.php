<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $table = 'invoice_product';
    protected $fillable = ['name','invoice_id','price','qty','total'];

    public function invoice()
    {
    	return $this->belongsTo(Invoice::class);

    }
} 
