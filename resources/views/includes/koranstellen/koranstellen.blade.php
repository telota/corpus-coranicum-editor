@foreach($koranstellenGroups as $counter => $koranstellenGroup)

    <h3>Zu Texststelle {{ $counter+1 }}</h3>

    <ul class="list-group">

        @foreach($koranstellenGroup as $koranstelle)

            <li class="list-group-item">
                <span class="label label-default">
                    {{ str_pad($koranstelle->sure, 3, 0, STR_PAD_LEFT) }}:{{ str_pad($koranstelle->vers, 3, 0, STR_PAD_LEFT) }}
                </span>

                <div class="paret">
                    {{ $koranstelle->getParet() }}
                </div>
                <hr>
                <div class="transliteration">
                    <em>{{ $koranstelle->getTransliteration() }}</em>
                </div>
            </li>

        @endforeach

    </ul>

@endforeach