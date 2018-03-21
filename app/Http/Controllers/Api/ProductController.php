<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Retrieve a quote.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function quote(Request $request)
    {
        $kappa = $request->all();
        $return = 0;
        foreach($request->all() as $k=>$v){
            $total = $v;
            $cost = 0;
            $product = Product::where('name',$k)->first();

            foreach($product->prices as $p)
            {
                if($total < $p->max_limit)
                {
                    $cost = $cost + ($total * $p->pence);
                    $total = 0;
                    break;
                }
                else{
                    $cost = $cost + ($p->max_limit * $p->pence);
                    $total = $total - $p->max_limit;
                }

            }
            $return = $return + $cost;
        }
        return response()->json($return/100);
    }
}
