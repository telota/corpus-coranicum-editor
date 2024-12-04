@foreach($manuskriptseite->bilder as $counter => $bild)

    <h5>
        <div>
            <span class="label label-default">{{ $counter + 1 }}</span>

            <a href="{{ $bild->fullPath }}" title="Volle Auflösung" target="_blank">
                <span class="glyphicon glyphicon-hover glyphicon-picture"></span>
            </a>

            {{ $bild->Bildlinknachweis }}

        </div>

    </h5>

    <img src="{{ $bild->modalPath }}"
         alt="{{ $bild->Bildlinknachweis }}"
         title="{{ $bild->Bildlinknachweis }}" class="jcrop-image">

@endforeach