<button class="btn {{$buttonClass}} text-white" data-toggle="modal" data-target="#{{ $id }}">
    {{$buttonMessage}}<span class="glyphicon glyphicon-{{$buttonIcon}} "
    ></span>
</button>
<div id="{{ $id }}" class="modal fade" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-body p-0">
                <div class="card border-0 p-sm-3 p-2 justify-content-center">
                    <div class="card-header pb-0 bg-white border-0 ">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="font-weight-bold">{{$title}}</h3>
                        <br>
                        {{$message}}
                        <br>
                    </div>
                    <div class="card-body px-sm-4 mb-2 pt-1 pb-0">
                        <button type="button" class="btn btn-light text-muted"
                                data-dismiss="modal">Cancel
                        </button>
                        {{$submit}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>