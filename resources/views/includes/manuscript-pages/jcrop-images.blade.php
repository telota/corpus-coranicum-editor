@foreach($manuscriptPage->images as $counter => $bild)

    <h5>
        <div>
            <span class="label label-default">{{ $counter + 1 }}</span>

            <a href="{{ $bild->fullPath }}" title="Volle Auflösung" target="_blank">
                <span class="glyphicon glyphicon-hover glyphicon-picture"></span>
            </a>

            {{ $bild->credit_line_image }}

        </div>

    </h5>

    <img src="{{ $bild->modalPath }}"
         alt="{{ $bild->credit_line_image }}"
         title="{{ $bild->credit_line_image }}" class="jcrop-image">

@endforeach
