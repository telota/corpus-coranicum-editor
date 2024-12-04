<span class="pull-right">
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="surenauswahl" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Sure auwählen
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="surenauswahl">
                    @for($i = 1; $i <= 114; $i++)

                        <li {{ ($i == $sure) ? 'class=active' : "" }}>
                            <a href="{{ URL::action([App\Http\Controllers\KoranController::class, 'indexBySura'], $i) }}">{{ $i }}</a></li>

                    @endfor
                </ul>
            </div>
        </span>