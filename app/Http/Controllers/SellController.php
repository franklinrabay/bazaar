<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Sell;
use App\Product;

use App\Services\SellService;

use Illuminate\Http\Request;

class SellController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$sells = Sell::orderBy('id', 'desc')->paginate(10);

		return view('sells.index', compact('sells'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sells.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$sell = new Sell();

		$sell->client = $request->client;
		$sell->payment_method = $request->payment_method;	

		$sell->save();

		$service = new SellService($sell, $request);
		$service->finish();

		return redirect()->route('sells.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sell = Sell::findOrFail($id);

		$service = new SellService($sell);
		$total = $service->total();

		return view('sells.show', compact('sell', 'total'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sell = Sell::findOrFail($id);

		return view('sells.edit', compact('sell'));
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
		$sell = Sell::findOrFail($id);

		$sell->client = $request->client;
		$sell->payment_method = $request->payment_method;	

		$sell->save();



		return redirect()->route('sells.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$sell = Sell::findOrFail($id);
		$sell->delete();

		return redirect()->route('sells.index')->with('message', 'Item deleted successfully.');
	}

}
