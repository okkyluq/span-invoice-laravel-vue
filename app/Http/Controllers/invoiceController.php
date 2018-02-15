<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\InvoiceProduct;
use App\Invoice;
use DB;

class invoiceController extends Controller
{
    
    public function auto(Request $request)
    {
        return DB::table('invoice')->where('client', 'LIKE', '%'.$request->q.'%')->get();
    }


    public function getDataInvoice(Request $request)
    {
        if ($request->search) {
            $data = DB::table('invoice')->where('client', 'LIKE', '%'.$request->search.'%')->orderBy('created_at', 'desc')->paginate(5);
        } else {
            $data =  DB::table('invoice')->orderBy('created_at', 'desc')->paginate(5);
        }
        
        return response()->json($data);
    }


    public function store(Request $request)
    {
    	$this->validate($request, [
    		'invoice_no' => 'required|numeric',
    		'client' => 'required',
    		'client_address' => 'required',
    		'tittle' => 'required',
    		'invoice_date' => 'required',
    		'products.*.name' => 'required',
    		'products.*.price' => 'required|numeric',
    		'products.*.qty' => 'required|numeric'
    	]);


        // return $products = collect($request->products);

        // disini yg bermasalah
        $products = collect($request->products)->transform(function($product) {
            $product['total'] = $product['qty'] * $product['price'];
            return new InvoiceProduct($product);
        });
        // dd($request->all());
        // return $products;

    	if ($products->isEmpty()) {
    		return response()->json([
    			'products_empty' => ['one or more product is required']
    		], 422);
    	}

    	$data = $request->except('products');
        $data['sub_total'] = $products->sum('total');
        $data['grand_total'] = $data['sub_total'] - (($data['discount']/100) * $data['sub_total']);

        $invoice = Invoice::create($data);
        $invoice->products()->saveMany($products);

        // $products = json_encode($products);

        // foreach ($products as $product) {
            
        //     $data = new InvoiceProduct;
        //     $data->invoice_id =  $invoice->id;
        //     $data->product_name =  $product->product_name;
        //     $data->price =  $product->price;
        //     $data->qty =  $product->qty;
        //     $data->total =  $product->total;
        //     $data->save();

        // }


        return response()->json([
            'created' => true,
            'id' => $invoice->id
        ]);
    }


    public function delete($id)
    {
        DB::table('invoice')->where('id', '=', $id)->delete();
        return response()->json([
            'deleted' => true
        ]);
    }


    public function detail($id)
    {
        // $invoice = DB::table('invoice')
        //             ->select('invoice.*', 'invoice_product.*')
        //             ->join('invoice_product', 'invoice.id', '=', 'invoice_product.invoice_id')
        //             ->where('invoice.id', '=', $id)
        //             ->get();

        $invoice = Invoice::with('products')->findOrFail($id);
        return response()->json($invoice);
        


    }


    public function update(Request $request)
    {
        $this->validate($request, [
            'invoice_no' => 'required|numeric',
            'client' => 'required',
            'client_address' => 'required',
            'tittle' => 'required',
            'invoice_date' => 'required',
            'products.*.name' => 'required',
            'products.*.price' => 'required|numeric',
            'products.*.qty' => 'required|numeric'
        ]);

        $invoice = Invoice::findOrfail($request->id);

        $products = collect($request->products)->transform(function($product) {
            $product['total'] = $product['qty'] * $product['price'];
            return new InvoiceProduct($product);
        });

        if ($products->isEmpty()) {
            return response()->json([
                'products_empty' => ['one or more product is required']
            ], 422);
        }

        $data = $request->except('products');
        $data['sub_total'] = $products->sum('total');
        $data['grand_total'] = $data['sub_total'] - (($data['discount']/100) * $data['sub_total']);

        $invoice->update($data);

        InvoiceProduct::where('invoice_id', $invoice->id)->delete();
        $invoice->products()->saveMany($products);

        return response()->json([
            'updated' => true,
            'id' => $invoice->id
        ]);

    }

}
