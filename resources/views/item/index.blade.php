@extends('layout')

@section('content')
    <script src="{{asset('assets/js/item/index.js')}}"></script>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Items</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success btn-custom" href="{{ route('item.create') }}">Create</a>
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
        <table class="table table-hover ">
            <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th width="230px">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                <tr class="line-item">
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>
                        <a class="btn btn-primary btn-custom" href="{{ route('item.edit',$item->id) }}">Edit</a>
                        <button type="button" data-id="{{$item->id}}" data-target="#deleteModal" data-toggle="modal"
                                class="btn btn-danger btn-custom delete-button">Delete
                        </button>
                    </td>
                </tr>
                <tr class="accordion" style="display: none">
                    <td colspan="5">
                        <div>
                            <div class="card bg-light text-center" style="max-width: 20rem;">
                                <div class="card-header"><h4>{{$item->name}}</h4></div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>Price &#36;</h5>
                                            <span>{{$item->price}}</span>
                                        </div>
                                        <div class="col-lg-6 margin-tb ">
                                            <h5>Stock</h5>
                                            <span>{{$item->stock}}</span>
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
            {!! $items->links() !!}
        </div>
        <div class="col-lg-6  text-right">
            <span>Showing {!!$items->firstItem()!!}-{!!$items->firstItem()+$items->count()-1!!} of {!! $items->total() !!}</span>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>Are you sure?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-custom" data-dismiss="modal">Close</button>

                    <form action="{{ route('item.destroy','') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-custom">Delete</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection
