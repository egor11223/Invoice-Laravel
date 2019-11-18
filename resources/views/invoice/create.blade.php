@extends('layout')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('assets/js/invoice/invoice.js')}}"></script>
    <script src="{{asset('assets/js/invoice/create.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <div class="row">
        <div class="col-lg-12 margin-tb text-center"> <h2>New Invoice</h2></div>
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

    <form method="POST">
        <div class="header-invoice">
            <div class="billing">
                <div class="form-group form-inline">
                    <span class="label-box">Bill To</span>
                </div>
                <div class="form-group form-inline">
                    <label for="street" class="label-box">Street</label>
                    <input class="form-control" id="street" name="street" type="text" placeholder="Street"
                           maxlength="50">
                </div>
                <div class="form-group form-inline">
                    <label for="zip_code" class="label-box">Zip</label>
                    <input class="form-control" id="zip_code" name="zip_code" type="text" placeholder="Zip"
                           maxlength="50">
                </div>
                <div class="form-group form-inline">
                    <label for="state" class="label-box">State</label>
                    <input class="form-control" id="state" name="state" type="text" placeholder="State" maxlength="50">
                </div>
                <div class="form-group form-inline">
                    <label for="city" class="label-box">City</label>
                    <input name="city" id="city" class="form-control" type="text" placeholder="City" maxlength="50">
                </div>
                <div class="form-group form-inline">
                    <label for="country" class="label-box">Country</label>
                    <select name="country" id="country" class="form-control">
                        <option value="" selected>Select</option>
                        @foreach($countries as $country)
                            <option value="{{$country}}">{{$country}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="invoice-info">
                <div class="form-inline form-group">
                    <label for="customer" class="label-box required">Customer</label>
                    <select name="customer" id="customer" class="form-control" autofocus>
                        <option value="" disabled selected>Select</option>
                        @foreach($customers as $customer)
                            <option
                                value="{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-inline form-group">
                    <label for="number" class="label-box">Invoice #</label>
                    <span id="number" name="number">{{$number}}</span>
                </div>
                <div class="form-inline form-group">
                    <label for="date" class="label-box">Date</label>
                    <input type="text" class="form-control" readonly name="date" maxlength="50">
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
                <tr>
                    <th scope="row">1</th>
                    <td>
                        <select name="item" class="form-control lineitem-item">
                            <option value="" selected disabled>Select</option>
                            @foreach($items as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control lineitem-qty" name="qty" value="0"></td>
                    <td><input type="text" readonly class="form-control lineitem-price" name="price" maxlength="50"
                               value="0"></td>
                    <td><input type="text" readonly class="form-control lineitem-total" name="total" maxlength="50"
                               value="0"></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-md delete-button">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <button type="button" id="add" class="btn btn-info">+ Add Item</button>
        <div class="footer-invoice header-invoice">
            <div class="tax-rate">
                <div class="form-inline form-group">
                    <label for="tax_rate" class="label-box">Tax Rate (%)</label>
                    <input type="number" class="form-control tax-rate" name="tax_rate" min="0" max="99"
                           step="0.01" value="0">
                </div>
            </div>

            <div class="invoice-info">
                <div class="form-inline form-group">
                    <label for="subtotal" class="label-box">Subtotal &#36;</label>
                    <input type="text" class="form-control footer" name="subtotal" value="0" readonly maxlength="50">
                </div>
                <div class="form-inline form-group">
                    <label for="tax" class="label-box">Tax &#36;</label>
                    <input type="text" class="form-control  footer" name="tax" value="0" maxlength="50">
                </div>
                <div class="form-inline form-group">
                    <label for="total-due" class="label-box">Total Due &#36;</label>
                    <input type="text" class="form-control footer" name="total-due" value="0" readonly maxlength="50">
                </div>
            </div>
        </div>

        <div class="row justify-content-md-left">
            <div class="col-md-6">
                <a class="btn btn-secondary btn-custom" href="{{ route('invoice.index') }}">Cancel</a>
                <button type="submit" class="btn btn-success btn-custom">Create</button>
            </div>
        </div>
    </form>
@endsection
