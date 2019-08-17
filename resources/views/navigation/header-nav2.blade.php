<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <div class="container">

        <div class="col-2">
            <a class="navbar-brand ml-auto" href="{{ url('/') }}">
                <img class="img-rounded block-center" src="/img/grow-my-profits.png" alt="Grow My Profits" title="Grow My Profits" style="width:100%;">
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav ml-auto">

                @can('isAdmin')

                <li class="nav-item">

                    <button class="btn btn-sm btn-link btn-outline-info" id="nav-user-admin">User Admin</button>

                </li>

                <li class="nav-item">

                    <button class="btn btn-sm btn-link btn-outline-info ml-2" id="nav-store-admin">Store Admin</button>

                </li>

                @endcan

            </ul>

            @include('navigation.header-user')

        </div>

    </div>

</nav>
