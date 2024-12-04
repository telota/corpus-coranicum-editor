@if($type == "header")

    @foreach($fields as $field)
        <div class="dropdown navbar-brand">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false">{{$field['name']}}<span class="caret"></span>
            </a>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                @foreach( $field['options'] as $option)
                    <li><a href="{{ $option['link'] }}">
                            @if($option['type'] == "list")
                                <x-icon type='th-list'/>
                            @elseif($option['type']== "add")
                                <x-icon type='plus'/>
                            @endif
                            {{$option['name']}}
                        </a></li>
                @endforeach
            </ul>
        </div>
    @endforeach

@else
    <div class="accordion" id="accordion">
        @foreach($fields as $field)
            {{--                    GENERAL CC--}}
            <div class="list-group-item list-group-item-head" id="{{$field['label']}}">
                <button class="btn btn-link" type="button" data-toggle="collapse"
                        data-target="#collapse{{$field['label']}}">
                    {{$field['name']}}
                </button>
            </div>

            <div id="collapse{{$field['label']}}" class="collapse" data-parent="#accordion">
                <div class="list-group">
                    @foreach( $field['options'] as $option)
                        <a href="{{ $option['link'] }}" class="list-group-item">
                            @if($option['type'] == "list")
                                <span class="glyphicon glyphicon-th-list"></span>
                            @elseif($option['type']== "add")
                                <span class="glyphicon glyphicon-plus"></span>
                            @endif
                            {{$option['name']}}
                        </a>
                    @endforeach
                </div>
            </div>
            <hr>
        @endforeach
    </div>
@endif
