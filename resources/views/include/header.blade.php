<nav class="navbar navbar-expand-lg bg-body-tertiary">
<div class="container-fluid">
    <a class="navbar-brand" href="#">{{config('app.name')}}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    @auth
        @if(!in_array(Route::currentRouteName(), ['login', 'register']))
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('produk.index')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('logout')}}">LogOut</a>
            </li>
        @endif
    @else
        @if(Route::currentRouteName() !== 'login')
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('login')}}">Login</a>
            </li>
        @endif
    @endauth    
    </ul>
    <span class="navbar-text">
        Toko Terbaik Di Alam Semesta
    </span>
    </div>
</div>
</nav>