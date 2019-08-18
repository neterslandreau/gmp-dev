<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <div class="container">

        <div class="col-4">
            <a class="navbar-brand ml-0" href="{{ url('/') }}">
                <img class="img-rounded block-center" src="/img/grow-my-profits.png" alt="Grow My Profits" title="Grow My Profits" style="width:100%;">
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav ml-auto">

            </ul>

            @include('navigation.header-user')

        </div>

    </div>

</nav>
@auth
@include('partials.modals.user-admin')
@include('partials.modals.store-admin')
@endauth
