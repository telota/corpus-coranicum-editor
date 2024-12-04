@foreach($manuscriptPage->images->sortBy('sort') as $bild)

    <hr>

    <h3>
        <div>
            <span class="label label-default">{{ $bild->sort }}</span>

            <a href="{{ $bild->fullPath }}" title="Volle Auflösung" target="_blank">
                <span class="glyphicon glyphicon-hover glyphicon-picture"></span>
            </a>

            {{ $bild->credit_line_image }}

        </div>

    </h3>

    <a href="{{ $bild->fullPath }}">
        <img src="{{ $bild->scalerPath }}"
             alt="{{ $bild->credit_line_image }}"
             title="{{ $bild->credit_line_image }}">
    </a>

@endforeach
