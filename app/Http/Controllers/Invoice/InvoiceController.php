<?php

namespace App\Http\Controllers\Invoice;

use App\Helpers\Autonumber;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Invoice;
use \GuzzleHttp\Client;
use App\Models\InvoiceItems;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use chillerlan\QRCode;

class InvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoices = Invoice::latest()->paginate(5);
        return view('invoice.index', compact('invoices'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = new Client();
        $response = $client->get('https://chitas.tk/geo/countrycity/countries');
        $countries = json_decode($response->getBody(), true);
        $customers = Customer::all();
        $items = Item::all();
        $number = Autonumber::getNextAutonumber('INV');
        return view('invoice.create', compact('countries', 'customers', 'items', 'number'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $invoice = $data['invoice'];
        $date = strtotime($invoice['date']);
        $invoice['date'] = date('Y-m-d', $date);

        $invoice = Invoice::create($invoice);
        Autonumber::setNextAutonumber('INV');
        $this->insertLineItems($data['lineItems'], $invoice->id);

        \Session::flash('success', 'Invoice has been successfully created.');
        return response($invoice->id, 200);
    }

    public function insertLineItems(array $lineItems, int $invoiceID)
    {
        array_walk($lineItems, function (&$value, &$key) use ($invoiceID) {
            $value['invoice_id'] = $invoiceID;
            unset($value['stock']);
        });

        InvoiceItems::insert($lineItems);
    }

    public function changeStockItems(array $lineItems)
    {
        foreach ($lineItems as $lineItem){
            $item = Item::find($lineItem['item_id']);
            $item->stock -= $lineItem['qty'];
            $item->save();
        }
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
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $client = new Client();
        $response = $client->get('https://chitas.tk/geo/countrycity/countries');
        $countries = json_decode($response->getBody(), true);
        $customers = Customer::all();
        $items = Item::all();
        return view('invoice.edit', compact(['invoice','countries','customers','items']))->with('i');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        dump($data);
        $invoicesExternalItems = InvoiceItems::where('invoice_id', $id)->get();

        $date = strtotime($data['invoice']['date']);
        $data['invoice']['date'] = date('Y-m-d', $date);

        unset($data['invoice']['id']);
        Invoice::where('id', $id)->update($data['invoice']);

        foreach ($invoicesExternalItems as $invoiceExternalItem){
            $emptyItem = array_search($invoiceExternalItem->item_id, array_column($data['lineItems'], 'item_id'));
            if($emptyItem === false){
                $invoiceExternalItem->forceDelete();
            }
        }

        foreach ($data['lineItems'] as $invoiceItem){
            $itemExternal = InvoiceItems::where([
                'invoice_id' => $id,
                'item_id' => $invoiceItem['item_id']
            ]);
            if($itemExternal->get()->isEmpty()){
                InvoiceItems::insert($invoiceItem);
            }else{
                $itemExternal->update($invoiceItem);
            }
        }

        \Session::flash('success', 'Invoice has been successfully updated.');

        return response('Success!', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->items()->delete();
        $invoice->delete();
        return redirect()->route('invoice.index')
            ->with('success', 'Invoice has been successfully deleted.');
    }
}
