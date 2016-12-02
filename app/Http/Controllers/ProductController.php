<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\Artisan;
use Illuminate\Http\Request;

class ProductController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$products = Product::orderBy('id', 'desc')->paginate(10);

		return view('products.index', compact('products'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		$artisans = Artisan::all('id', 'name');
		return view('products.create', compact('artisans'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$product = new Product();

		$product->name = $request->input("name");
        $product->value = $request->input("value");
        $product->amount = $request->input("amount");
        $product->artisan_id = $request->input("artisan_id");

		$product->save();

		return redirect()->route('products.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$product = Product::findOrFail($id);

		return view('products.show', compact('product'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$product = Product::findOrFail($id);
		$artisans = Artisan::all('id', 'name');

		return view('products.edit', compact('product', 'artisans'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$product = Product::findOrFail($id);

		$product->name = $request->input("name");
        $product->value = $request->input("value");
        $product->amount = $request->input("amount");
        $product->artisan_id = $request->input("artisan_id");

		$product->save();

		return redirect()->route('products.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$product = Product::findOrFail($id);
		$product->delete();

		return redirect()->route('products.index')->with('message', 'Item deleted successfully.');
	}

}
