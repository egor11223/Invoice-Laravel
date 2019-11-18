@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Invoices</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success btn-custom" href="{{ route('invoice.create') }}">Create</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <span>{{ $message }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <span>{{ $message }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Number</th>
                <th>Date</th>
                <th>Customer</th>
                <th width="230px">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($invoices as $invoice)
                <tr class="line-item">
                    <td>{{ ++$i }}</td>
                    <td>{{ $invoice->number }}</td>
                    <td>{{ $invoice->date }}</td>
                    <td>{{ $invoice->customer->first_name .' '.  $invoice->customer->last_name}}</td>
                    <td>
                        <a class="btn btn-primary btn-custom" href="{{ route('invoice.edit',$invoice->id) }}">Edit</a>
                        <button type="button" data-id="{{$invoice->id}}" data-target="#deleteModal" data-toggle="modal"
                                class="btn btn-danger btn-custom delete-button">Delete
                        </button>
                    </td>
                </tr>
                <tr class="accordion" style="display: none">
                    <td colspan="5">
                        <div>
                            <div class="card bg-light text-center">
                                <div class="card-header"><h4>{{ $invoice->number}}</h4></div>
                                <div class="card-body ">
                                    <div class="header-invoice">
                                        <div class="billing">
                                            <div class="form-group form-inline">
                                                <span class="label-box">Bill To</span>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label class="label-box">Street</label>
                                                <span>{{$invoice->street}}</span>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label class="label-box">Zip</label>
                                                <span>{{$invoice->zip_code}}</span>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label class="label-box">State</label>
                                                <span>{{$invoice->state}}</span>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label class="label-box">City</label>
                                                <span>{{$invoice->city}}</span>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label class="label-box">Country</label>
                                                <span>{{$invoice->country}}</span>
                                            </div>
                                        </div>
                                        <div class="invoice-info">
                                            <div class="qr-code">
                                                {!! QrCode::size(150)->generate(url('/').'/invoice/'.$invoice->id.'/edit'); !!}
                                            </div>
                                            <div class="form-inline form-group">
                                                <label class="label-box required">Customer</label>
                                                <span>{{$invoice->customer->first_name .' '.  $invoice->customer->last_name}}</span>
                                            </div>
                                            <div class="form-inline form-group">
                                                <label class="label-box">Invoice #</label>
                                                <span>{{$invoice->number}}</span>
                                            </div>
                                            <div class="form-inline form-group">
                                                <label for="date" class="label-box">Date</label>
                                                <span>{{$invoice->date}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-control-lg">
                                        <h3>Items</h3>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table" id="items">
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
                                            <tbody>
                                            @foreach($invoice->items as $key => $li)
                                                <tr>
                                                    <th scope="row">{{$key + 1}}</th>
                                                    <td><span>{{$li->item->name}}</span></td>
                                                    <td><span>{{$li->qty}}</span></td>
                                                    <td><span>{{$li->price}}</span></td>
                                                    <td><span>{{$li->qty * $li->price}}</span></td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="footer-invoice header-invoice">
                                        <div class="tax-rate">
                                            <div class="form-inline form-group">
                                                <label class="label-box">Tax Rate (%)</label>
                                                <span>{{$invoice->tax_rate}}</span>
                                            </div>
                                        </div>

                                        <div class="invoice-info">
                                            <div class="form-inline form-group">
                                                <label for="subtotal" class="label-box">Subtotal &#36;</label>
                                                <span>{{$invoice->subtotal}}</span>
                                            </div>
                                            <div class="form-inline form-group">
                                                <label class="label-box">Tax &#36;</label>
                                                <span>{{$invoice->tax}}</span>
                                            </div>
                                            <div class="form-inline form-group">
                                                <label for="total-due" class="label-box">Total Due &#36;</label>
                                                <span>{{$invoice->total}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col-lg-6 ">
            {!! $invoices->links() !!}
        </div>
        <div class="col-lg-6  text-right">
            <span>Showing {!!$invoices->firstItem()!!}-{!!$invoices->firstItem()+$invoices->count()-1!!} of {!! $invoices->total() !!}</span>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>Are you sure?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-custom" data-dismiss="modal">Close</button>
                    <form action="{{ route('invoice.destroy','') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-custom">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
