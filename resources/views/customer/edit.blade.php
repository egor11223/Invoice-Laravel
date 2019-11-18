@extends('layout')

@section('content')
    <script src="{{asset('assets/js/phone_mask/cleave.js')}}"></script>
    <script src="{{asset('assets/js/phone_mask/cleave-phone.i18n.js')}}"></script>
    <script src="{{asset('assets/js/customer/form.js')}}"></script>
    <div class="row">
        <div class="col-lg-12 margin-tb text-center">
            <div class="pull-left">
                <h2>Edit Customer</h2>
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

    <form action="{{route('customer.update', $customer->id)}}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label class="required" for="first-name">First Name</label>
                    <input type="text" class="form-control" maxlength="50" id="first-name" name="first_name"
                           value="{{$customer->first_name}}" placeholder="First Name" autofocus>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="required" for="first-name">Last Name</label>
                    <input type="text" class="form-control" maxlength="50" id="last-name" name="last_name"
                           value="{{$customer->last_name}}" placeholder="Last Name">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label class="required" for="email">Email</label>
                    <input type="email" maxlength="50" class="form-control" id="email" name="email"
                           placeholder="Email" value="{{$customer->email}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="required" for="phone">Phone</label>
                    <div class="row">
                        <div class="col-md-4" style="padding-right: 0">
                            <select class="form-control" id="select-country">
                                <option value="US" selected>US</option>
                                <option value="AC">AC</option>
                                <option value="AD">AD</option>
                                <option value="AE">AE</option>
                                <option value="AF">AF</option>
                                <option value="AG">AG</option>
                                <option value="AI">AI</option>
                                <option value="AL">AL</option>
                                <option value="AM">AM</option>
                                <option value="AO">AO</option>
                                <option value="AR">AR</option>
                                <option value="AS">AS</option>
                                <option value="AT">AT</option>
                                <option value="AU">AU</option>
                                <option value="AW">AW</option>
                                <option value="AX">AX</option>
                                <option value="AZ">AZ</option>
                                <option value="BA">BA</option>
                                <option value="BB">BB</option>
                                <option value="BD">BD</option>
                                <option value="BE">BE</option>
                                <option value="BF">BF</option>
                                <option value="BG">BG</option>
                                <option value="BH">BH</option>
                                <option value="BI">BI</option>
                                <option value="BJ">BJ</option>
                                <option value="BL">BL</option>
                                <option value="BM">BM</option>
                                <option value="BN">BN</option>
                                <option value="BO">BO</option>
                                <option value="BQ">BQ</option>
                                <option value="BR">BR</option>
                                <option value="BS">BS</option>
                                <option value="BT">BT</option>
                                <option value="BW">BW</option>
                                <option value="BY">BY</option>
                                <option value="BZ">BZ</option>
                                <option value="CA">CA</option>
                                <option value="CC">CC</option>
                                <option value="CD">CD</option>
                                <option value="CF">CF</option>
                                <option value="CG">CG</option>
                                <option value="CH">CH</option>
                                <option value="CI">CI</option>
                                <option value="CK">CK</option>
                                <option value="CL">CL</option>
                                <option value="CM">CM</option>
                                <option value="CN">CN</option>
                                <option value="CO">CO</option>
                                <option value="CR">CR</option>
                                <option value="CU">CU</option>
                                <option value="CV">CV</option>
                                <option value="CW">CW</option>
                                <option value="CX">CX</option>
                                <option value="CY">CY</option>
                                <option value="CZ">CZ</option>
                                <option value="DE">DE</option>
                                <option value="DJ">DJ</option>
                                <option value="DK">DK</option>
                                <option value="DM">DM</option>
                                <option value="DO">DO</option>
                                <option value="DZ">DZ</option>
                                <option value="EC">EC</option>
                                <option value="EE">EE</option>
                                <option value="EG">EG</option>
                                <option value="EH">EH</option>
                                <option value="ER">ER</option>
                                <option value="ES">ES</option>
                                <option value="ET">ET</option>
                                <option value="FI">FI</option>
                                <option value="FJ">FJ</option>
                                <option value="FK">FK</option>
                                <option value="FM">FM</option>
                                <option value="FO">FO</option>
                                <option value="FR">FR</option>
                                <option value="GA">GA</option>
                                <option value="GB">GB</option>
                                <option value="GD">GD</option>
                                <option value="GE">GE</option>
                                <option value="GF">GF</option>
                                <option value="GG">GG</option>
                                <option value="GH">GH</option>
                                <option value="GI">GI</option>
                                <option value="GL">GL</option>
                                <option value="GM">GM</option>
                                <option value="GN">GN</option>
                                <option value="GP">GP</option>
                                <option value="GQ">GQ</option>
                                <option value="GR">GR</option>
                                <option value="GT">GT</option>
                                <option value="GU">GU</option>
                                <option value="GW">GW</option>
                                <option value="GY">GY</option>
                                <option value="HK">HK</option>
                                <option value="HN">HN</option>
                                <option value="HR">HR</option>
                                <option value="HT">HT</option>
                                <option value="HU">HU</option>
                                <option value="ID">ID</option>
                                <option value="IE">IE</option>
                                <option value="IL">IL</option>
                                <option value="IM">IM</option>
                                <option value="IN">IN</option>
                                <option value="IO">IO</option>
                                <option value="IQ">IQ</option>
                                <option value="IR">IR</option>
                                <option value="IS">IS</option>
                                <option value="IT">IT</option>
                                <option value="JE">JE</option>
                                <option value="JM">JM</option>
                                <option value="JO">JO</option>
                                <option value="JP">JP</option>
                                <option value="KE">KE</option>
                                <option value="KG">KG</option>
                                <option value="KH">KH</option>
                                <option value="KI">KI</option>
                                <option value="KM">KM</option>
                                <option value="KN">KN</option>
                                <option value="KP">KP</option>
                                <option value="KR">KR</option>
                                <option value="KW">KW</option>
                                <option value="KY">KY</option>
                                <option value="KZ">KZ</option>
                                <option value="LA">LA</option>
                                <option value="LB">LB</option>
                                <option value="LC">LC</option>
                                <option value="LI">LI</option>
                                <option value="LK">LK</option>
                                <option value="LR">LR</option>
                                <option value="LS">LS</option>
                                <option value="LT">LT</option>
                                <option value="LU">LU</option>
                                <option value="LV">LV</option>
                                <option value="LY">LY</option>
                                <option value="MA">MA</option>
                                <option value="MC">MC</option>
                                <option value="MD">MD</option>
                                <option value="ME">ME</option>
                                <option value="MF">MF</option>
                                <option value="MG">MG</option>
                                <option value="MH">MH</option>
                                <option value="MK">MK</option>
                                <option value="ML">ML</option>
                                <option value="MM">MM</option>
                                <option value="MN">MN</option>
                                <option value="MO">MO</option>
                                <option value="MP">MP</option>
                                <option value="MQ">MQ</option>
                                <option value="MR">MR</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="MU">MU</option>
                                <option value="MV">MV</option>
                                <option value="MW">MW</option>
                                <option value="MX">MX</option>
                                <option value="MY">MY</option>
                                <option value="MZ">MZ</option>
                                <option value="NA">NA</option>
                                <option value="NC">NC</option>
                                <option value="NE">NE</option>
                                <option value="NF">NF</option>
                                <option value="NG">NG</option>
                                <option value="NI">NI</option>
                                <option value="NL">NL</option>
                                <option value="NO">NO</option>
                                <option value="NP">NP</option>
                                <option value="NR">NR</option>
                                <option value="NU">NU</option>
                                <option value="NZ">NZ</option>
                                <option value="OM">OM</option>
                                <option value="PA">PA</option>
                                <option value="PE">PE</option>
                                <option value="PF">PF</option>
                                <option value="PG">PG</option>
                                <option value="PH">PH</option>
                                <option value="PK">PK</option>
                                <option value="PL">PL</option>
                                <option value="PM">PM</option>
                                <option value="PR">PR</option>
                                <option value="PS">PS</option>
                                <option value="PT">PT</option>
                                <option value="PW">PW</option>
                                <option value="PY">PY</option>
                                <option value="QA">QA</option>
                                <option value="RE">RE</option>
                                <option value="RO">RO</option>
                                <option value="RS">RS</option>
                                <option value="RU">RU</option>
                                <option value="RW">RW</option>
                                <option value="SA">SA</option>
                                <option value="SB">SB</option>
                                <option value="SC">SC</option>
                                <option value="SD">SD</option>
                                <option value="SE">SE</option>
                                <option value="SG">SG</option>
                                <option value="SH">SH</option>
                                <option value="SI">SI</option>
                                <option value="SJ">SJ</option>
                                <option value="SK">SK</option>
                                <option value="SL">SL</option>
                                <option value="SM">SM</option>
                                <option value="SN">SN</option>
                                <option value="SO">SO</option>
                                <option value="SR">SR</option>
                                <option value="SS">SS</option>
                                <option value="ST">ST</option>
                                <option value="SV">SV</option>
                                <option value="SX">SX</option>
                                <option value="SY">SY</option>
                                <option value="SZ">SZ</option>
                                <option value="TA">TA</option>
                                <option value="TC">TC</option>
                                <option value="TD">TD</option>
                                <option value="TG">TG</option>
                                <option value="TH">TH</option>
                                <option value="TJ">TJ</option>
                                <option value="TK">TK</option>
                                <option value="TL">TL</option>
                                <option value="TM">TM</option>
                                <option value="TN">TN</option>
                                <option value="TO">TO</option>
                                <option value="TR">TR</option>
                                <option value="TT">TT</option>
                                <option value="TV">TV</option>
                                <option value="TW">TW</option>
                                <option value="TZ">TZ</option>
                                <option value="UA">UA</option>
                                <option value="UG">UG</option>
                                <option value="UY">UY</option>
                                <option value="UZ">UZ</option>
                                <option value="VA">VA</option>
                                <option value="VC">VC</option>
                                <option value="VE">VE</option>
                                <option value="VG">VG</option>
                                <option value="VI">VI</option>
                                <option value="VN">VN</option>
                                <option value="VU">VU</option>
                                <option value="WF">WF</option>
                                <option value="WS">WS</option>
                                <option value="YE">YE</option>
                                <option value="YT">YT</option>
                                <option value="ZA">ZA</option>
                                <option value="ZM">ZM</option>
                                <option value="ZW">ZW</option>
                            </select>
                        </div>
                        <div class="col-md-8" style="padding-left: 0">
                            <input type="text" maxlength="15" class="form-control" id="phone" name="phone"
                                   placeholder="Phone" value="{{$customer->phone}}">
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
                        <option value="">Select</option>
                        @if(!empty($customer->country))
                            <option value="{{$customer->country}}" selected>{{$customer->country}}</option>
                        @endif
                        @foreach($countries as $country)
                            <option value="{{$country}}">{{$country}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="state">State</label>
                    <input class="form-control" id="state" name="state" type="text" maxlength="50" placeholder="State"
                           value="{{$customer->state}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label for="city">City</label>
                    <input class="form-control" id="city" name="city" type="text" maxlength="50" placeholder="City"
                           value="{{$customer->city}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="text" class="form-control" id="street" name="street" maxlength="50"
                           placeholder="Street" value="{{$customer->street}}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <div class="form-group">
                    <label for="zip_code">Zip</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code" maxlength="50"
                           placeholder="Zip" value="{{$customer->zip_code}}">
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-6 text-right">
                <a class="btn btn-secondary btn-custom" href="{{ route('customer.index') }}">Cancel</a>
                <button type="submit" class="btn btn-success btn-custom">Update</button>
            </div>
        </div>
    </form>
@endsection
