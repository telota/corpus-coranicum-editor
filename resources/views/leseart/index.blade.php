@extends("layouts.master")

@section("title")

    <h1>

        Lesarten

        @if(!($lesearten->currentPage() == $lesearten->lastPage()))

            ({{ (($lesearten->currentPage() - 1) * $lesearten->count()) + 1 }} -
            {{ $lesearten->count() * $lesearten->currentPage() }})

        @else

            ({{ ($lesearten->currentPage() - 1) * 500   }} -
            {{ $lesearten->total() }})

        @endif

        <a href="{{ URL::route("lesearten.create") }}">
            <span class="glyphicon glyphicon-plus glyphicon-hover"></span>
        </a>
    </h1>

@endsection


@section("content")

    @include("includes.leseart.leseartenTable")

    <hr>

    <nav class="text-center">
        <ul class="pagination">
            <li>
                <a href="{{ $lesearten->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            @for($i = 1; $i <= $lesearten->lastPage(); $i++)

                <li {{ ($i == $lesearten->currentPage()) ? 'class=active' : '' }}>
                    <a href="{{ $lesearten->url($i) }}">
                        {{ $i }}
                    </a>
                </li>

            @endfor
            <li>
                <a href="{{ $lesearten->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>



@endsection