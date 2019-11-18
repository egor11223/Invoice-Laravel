@extends('layout')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('assets/js/invoice/invoice.js')}}"></script>
    <script src="{{asset('assets/js/invoice/update.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <div class="row">
        <div class="col-lg-12 margin-tb text-center"><h2>Edit Invoice</h2></div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" data-id="{{$invoice->id}}">

        <div class="header-invoice">
            <div class="billing">
                <div class="form-group form-inline">
                    <span class="label-box">Bill To</span>
                </div>
                <div class="form-group form-inline">
                    <label for="street" class="label-box">Street</label>
                    <input class="form-control" value="{{$invoice->street}}" id="street" name="street" type="text"
                           placeholder="Street" maxlength="50">
                </div>
                <div class="form-group form-inline">
                    <label for="zip_code" class="label-box">Zip</label>
                    <input class="form-control" id="zip_code" value="{{$invoice->zip_code}}" name="zip_code"
                           type="text" placeholder="Zip" maxlength="50">
                </div>
                <div class="form-group form-inline">
                    <label for="state" class="label-box">State</label>
                    <input class="form-control" id="state" name="state" value="{{$invoice->state}}" type="text"
                           placeholder="State" maxlength="50">
                </div>
                <div class="form-group form-inline">
                    <label for="city" class="label-box">City</label>
                    <input name="city" id="city" class="form-control" type="text" value="{{$invoice->city}}"
                           placeholder="City" maxlength="50">
                </div>
                <div class="form-group form-inline">
                    <label for="country" class="label-box">Country</label>
                    <select name="country" id="country" class="form-control">
                        <option value="" selected>Select</option>
                        @foreach($countries as $country)
                            <option
                                @if($country == $invoice->country)
                                selected
                                @endif
                                value="{{$country}}">{{$country}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="invoice-info">
                <div class="qr-code">
                    {!! QrCode::size(150)->generate(url('/').'/invoice/'.$invoice->id.'/edit') !!}
                </div>
                <div class="form-inline form-group">
                    <label for="customer" class="label-box required">Customer</label>
                    <select name="customer" id="customer" class="form-control" autofocus>
                        <option value="" selected>Select</option>
                        @foreach($customers as $customer)
                            <option
                                @if($customer->id == $invoice->customer->id )
                                selected
                                @endif
                                value="{{$customer->id}}"
                            >
                                {{$customer->first_name.' '.$customer->last_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-inline form-group">
                    <label for="number" class="label-box">Invoice #</label>
                    <span id="number" name="number">{{$invoice->number}}</span>
                </div>
                <div class="form-inline form-group">
                    <label for="date" class="label-box">Date</label>
                    <input type="text" class="form-control" value="{{$invoice->date}}" readonly name="date"
                           maxlength="50">
                </div>
            </div>
        </div>

        <div class="row form-control-lg">
            <h3>Items</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="items">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="required">Item</th>
                    <th scope="col" class="required">Qty</th>
                    <th scope="col">Price &#36;</th>
                    <th scope="col">Total &#36;</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody id="list-items">
                @foreach($invoice->items as $li)
                    <tr>
                        <th scope="row">{{++$i}}</th>
                        <td>
                            <select name="item" class="form-control lineitem-item">
                                @foreach($items as $item)
                                    <option
                                        @if($item->id == $li->item_id )
                                        selected
                                        @endif
                                        value="{{$item->id}}"
                                    >
                                        {{$item->name}}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" class="form-control lineitem-qty" value="{{$li->qty}}" name="qty"></td>
                        <td><input type="text" readonly class="form-control lineitem-price" name="price"
                                   value="{{$li->price}}"
                                   maxlength="50"></td>
                        <td><input type="text" readonly class="form-control lineitem-total" name="total"
                                   value="{{$li->qty * $li->price}}"
                                   maxlength="50"></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-md delete-button">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <button type="button" id="add" class="btn btn-info">+ Add Item</button>
        <div class="footer-invoice header-invoice">
            <div class="tax-rate">
                <div class="form-inline form-group">
                    <label for="tax_rate" class="label-box">Tax Rate (%)</label>
                    <input type="number" class="form-control tax-rate" name="tax_rate" min="0" max="99"
                           value="{{$invoice->tax_rate}}"
                           step="0.01">
                </div>
            </div>

            <div class="invoice-info">
                <div class="form-inline form-group">
                    <label for="subtotal" class="label-box">Subtotal &#36;</label>
                    <input type="text" class="form-control footer" name="subtotal" value="{{$invoice->subtotal}}"
                           readonly maxlength="50">
                </div>
                <div class="form-inline form-group">
                    <label for="tax" class="label-box">Tax &#36;</label>
                    <input type="text" class="form-control  footer" name="tax" value="{{$invoice->tax}}" maxlength="50">
                </div>
                <div class="form-inline form-group">
                    <label for="total-due" class="label-box">Total Due &#36;</label>
                    <input type="text" class="form-control footer" name="total-due" value="{{$invoice->total}}" readonly
                           maxlength="50">
                </div>
            </div>
        </div>

        <div class="row justify-content-md-left">
            <div class="col-md-6">
                <a class="btn btn-secondary btn-custom" href="{{ route('invoice.index') }}">Cancel</a>
                <button type="submit" class="btn btn-success btn-custom">Update</button>
            </div>
        </div>
    </form>
@endsection
