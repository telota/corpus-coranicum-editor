@foreach($manuskriptseite->bilder->sortBy('sort') as $bild)

    <hr>

    <h3>
        <div>
            <span class="label label-default">{{ $bild->sort }}</span>

            <a href="{{ $bild->fullPath }}" title="Volle Auflösung" target="_blank">
                <span class="glyphicon glyphicon-hover glyphicon-picture"></span>
            </a>

            {{ $bild->Bildlinknachweis }}

        </div>

    </h3>

    <a href="{{ $bild->fullPath }}">
        <img src="{{ $bild->scalerPath }}"
             alt="{{ $bild->Bildlinknachweis }}"
             title="{{ $bild->Bildlinknachweis }}">
    </a>

@endforeach