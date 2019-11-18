<?php

namespace App\Http\Controllers\Item;

use App\Helpers\Autonumber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use mysql_xdevapi\Exception;
use function Psy\debug;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::latest()->paginate(5);
        return view('item.index', compact('items'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);


        Item::create($request->all());

        return redirect()->route('item.index')->with('success', 'Item has been successfully created.');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('item.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);

        $item->update($request->all());
        return redirect()->route('item.index')
            ->with('success', 'Item has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        if(empty($item->invoiceItems)){
            try {
                $item->delete();
                return redirect()->route('item.index')
                    ->with('success', 'Item has been successfully deleted.');
            } catch (\Exception $e) {
                return redirect()->route('item.index')
                    ->with('error', 'Deleted failed!');
            }
        }else{
            return redirect()->route('item.index')
                ->with('error', 'This item is included in the order!');
        }

    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function listItems()
    {
        $items = Item::all();
        return response($items->toJson(), 200);
    }
}
