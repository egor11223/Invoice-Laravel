<!DOCTYPE html>
<html>
<head>
    <title>Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ Request::is('customer') ? 'active' : '' }}">
                <a class="nav-link {{ Request::is('customer') ? 'disabled' : '' }}" href="{{ url('customer') }}">Customers</a>
                <a href="{{url('customer/create')}}" class="nav-link {{Request::is('customer/create') ? 'disabled' : ''}}">
                    <img src="{{asset('img/add.png')}}" alt="add"
                         class="add">
                </a>
            </li>
            <li class="nav-item {{ Request::is('item') ? 'active' : '' }}">
                <a class="nav-link {{ Request::is('item') ? 'disabled' : '' }}" href="{{ url('item') }}">Items</a>
                <a href="{{url('item/create')}}" class="nav-link {{Request::is('item/create') ? 'disabled' : ''}}">
                    <img src="{{asset('img/add.png')}}" alt="add"
                         class="add">
                </a>
            </li>
            <li class="nav-item {{ Request::is('invoice') ? 'active' : '' }}">
                <a class="nav-link {{ Request::is('invoice') ? 'disabled' : '' }}"
                   href="{{ url('invoice') }}">Invoices</a>
                <a href="{{url('invoice/create')}}" class="nav-link {{Request::is('invoice/create') ? 'disabled' : ''}}">
                    <img src="{{asset('img/add.png')}}" alt="add"
                         class="add">
                </a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    @yield('content')
</div>

</body>
</html>
