<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CountryCode;
use Illuminate\Http\Request;
use App\Models\Customer;
use \GuzzleHttp\Client;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(5);
        return view('customer.index', compact('customers'))
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
        $codes = CountryCode::all();
        return view('customer.create', compact(['countries', 'codes']));
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);


        Customer::create($request->all());

        return redirect()->route('customer.index')->with('success', 'Customer has been successfully created.');
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
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $client = new Client();
        $response = $client->get('https://chitas.tk/geo/countrycity/countries');
        $countries = json_decode($response->getBody(), true);
        return view('customer.edit', compact('customer', 'countries'));
    }


    /**
     * @param Request $request
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $customer->update($request->all());

        return redirect()->route('customer.index')
            ->with('success', 'Customer has been successfully updated.');
    }


    /**
     * @param Customer $customer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        if(empty($customer->invoice)){
            try{
                $customer->delete();
                return redirect()->route('customer.index')
                    ->with('success', 'Customer has been successfully deleted.');
            }catch (\Exception $e){
                return redirect()->route('customer.index')
                    ->with('error', 'Deleted failed!');
            }
        }else{
            return redirect()->route('customer.index')
                ->with('error', 'This customer has an order!');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getCustomer($id)
    {
        $customer = Customer::find($id);
        return response($customer, 200);
    }
}
