<nav class="navbar navbar-default navbar-fixed-top custom-fixed">
    <div class="container-fluid">
        {{-- <!-- Brand and toggle get grouped for better mobile display --> --}}
        <div class="navbar-header">
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="" style="max-height: 1.5rem !important;">

            <div class="dropdown navbar-brand">
                <a role="button" href="{{ route('home') }}">
                    Home
                </a>
            </div>

            <x-menu :type="'header'"/>

            @if (Auth::check())
                <ul class="nav navbar-nav navbar-right" style="right: 0;left:auto">

                    @if (Auth::user()->isAdmin())
                        <li><a href="{{ URL::action([App\Http\Controllers\AdminController::class, 'index']) }}">
                                <span class="glyphicon glyphicon-wrench"></span> Verwaltung
                            </a>
                        </li>
                    @endif

                    <li>
                        <a href="/logout" id="logout-button">
                            <span class="glyphicon glyphicon-off"></span> {{ Auth::user()->name }}</a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            @endif

        </div>
    </div>
</nav>
