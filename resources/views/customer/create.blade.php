@extends('layout')

@section('content')
    <script src="{{asset('assets/js/phone_mask/cleave.js')}}"></script>
    <script src="{{asset('assets/js/phone_mask/cleave-phone.i18n.js')}}"></script>
    <script src="{{asset('assets/js/customer/form.js')}}"></script>
    <div class="row">
        <div class="col-lg-12 margin-tb text-center">
            <div class="pull-left">
                <h2>Create Customer</h2>
            </div>
        </div>
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

    <form action="{{route('customer.store')}}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label class="required" for="first-name">First Name</label>
                    <input type="text" maxlength="50" class="form-control" id="first-name" name="first_name"
                           placeholder="First Name" autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="required" for="first-name">Last Name</label>
                    <input type="text" maxlength="50" class="form-control" id="last-name" name="last_name"
                           placeholder="Last Name">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label class="required" for="email">Email</label>
                    <input type="email" maxlength="50" class="form-control" id="email" name="email"
                           placeholder="Email">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="required" for="phone">Phone</label>
                    <div class="row">
                        <div class="col-md-4" style="padding-right: 0">
                            <select class="form-control" name="code_id" id="select-country">
                                @foreach ($codes as $code)
                                    <option value="{{$code->id}}">{{$code->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8" style="padding-left: 0">
                            <input type="text" maxlength="15" class="form-control" id="phone" name="phone"
                                   placeholder="Phone">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label for="country">Country</label>
                    <select name="country" id="country" class="form-control">
                        <option value="" selected>Select</option>
                        @foreach($countries as $country)
                            <option value="{{$country}}">{{$country}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="state">State</label>
                    <input class="form-control" id="state" name="state" type="text" maxlength="50" placeholder="State">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label for="city">City</label>
                    <input class="form-control" id="city" name="city" type="text" maxlength="50" placeholder="City">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" id="street" name="street" maxlength="50"
                           placeholder="Street">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label for="zip_code">Zip</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code" maxlength="50"
                           placeholder="Zip">
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-6 text-right">
                <a class="btn btn-secondary btn-custom" href="{{ route('customer.index') }}">Cancel</a>
                <button type="submit" class="btn btn-success btn-custom">Create</button>
            </div>
        </div>
    </form>

@endsection
