<?php

namespace App\Services;

use App\Sell;
use App\Product;
use Illuminate\Http\Request;

class SellService
{
    protected $sell;
    protected $request;

    public function __construct(Sell $sell, Request $request = null)
    {
        $this->sell = $sell;
        $this->request = $request;
    }

    public function finish()
    {
        foreach ($this->request->product as $key => $value) {
            $products[] = $key;

            $product = Product::find($key);
            $product->amount -= $value['amount'];
            $product->save();
            
            $this->sell->products()->save($product, ['amount' => $value['amount'], 'value' => $value['value']]);
        }

    }

    public function total()
    {
        $total = 0;
        
        foreach ($this->sell->products as $product) {
            $total += $product->pivot->value * $product->pivot->amount;
        }

        return $total;
    }
}
