@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div>
                <h2>Customers</h2>
            </div>
            <div>
                <a class="btn btn-success btn-custom" href="{{ route('customer.create') }}"> Create</a>
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
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th width="230px">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($customers as $customer)
                <tr class="line-item">
                    <td>{{ ++$i }}</td>
                    <td>{{ $customer->first_name.' '.$customer->last_name}}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>
                        <a class="btn btn-primary btn-custom" href="{{ route('customer.edit',$customer->id) }}">Edit</a>
                        <button type="button" data-id="{{$customer->id}}" data-target="#deleteModal" data-toggle="modal"
                                class="btn btn-danger btn-custom delete-button">Delete
                        </button>
                    </td>
                </tr>
                <tr class="accordion" style="display: none">
                    <td colspan="5">
                        <div>
                            <div class="card bg-light " style="max-width: 30rem;">
                                <div class="card-header"><h4>{{$customer->first_name.' '.$customer->last_name}}</h4></div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>First Name:</h5>
                                            <span >{{$customer->first_name}}</span>
                                        </div>
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>Last Name:</h5>
                                            <span >{{$customer->last_name}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>Email:</h5>
                                            <span >{{$customer->email}}</span>
                                        </div>
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>Phone:</h5>
                                            <span >{{$customer->phone}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>Country:</h5>
                                            <span >{{$customer->country}}</span>
                                        </div>
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>State:</h5>
                                            <span >{{$customer->state}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>City:</h5>
                                            <span >{{$customer->city}}</span>
                                        </div>
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>Street:</h5>
                                            <span >{{$customer->street}}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>Zip:</h5>
                                            <span >{{$customer->zip_code}}</span>
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
            {!! $customers->links() !!}
        </div>
        <div class="col-lg-6  text-right">
            <span>Showing {!!$customers->firstItem()!!}-{!!$customers->firstItem()+$customers->count()-1!!} of {!! $customers->total() !!}</span>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>Are you sure?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-custom" data-dismiss="modal">Close</button>

                    <form action="{{ route('customer.destroy','') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-custom">Delete</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
