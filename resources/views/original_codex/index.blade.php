@extends("layouts.master")
@section("title")
   Sister Leaves
   <a href="{{ URL::action([App\Http\Controllers\ManuscriptOriginalCodexController::class, 'create'])}}">
                        <span class="btn btn-primary">
                            <span class="glyphicon glyphicon-pencil"></span> Neu
                        </span>
   </a>
@endsection

@section("content")
   <table class="table table-striped">
      <thead>
      <tr>
         <th scope="col">Id</th>
         <th scope="col">Name</th>
         <th scope="col">Oberkategorie</th>
         <th scope="col">Sister Leaves</th>
         <th scope="col"></th>
      </tr>
      </thead>
      <tbody>
      @foreach($manuskriptOriginalCodex as $codex)
         <tr>
            <td>{{$codex->id}}</td>
            <td>{{$codex->original_codex_name}}</td>
            <td>
            @foreach($manuskriptOriginalCodex as $oberkategorie)
               @if($oberkategorie->id == $codex->supercategory)
            {{$oberkategorie->name}} (ID: {{$oberkategorie->id}})
               @endif
            @endforeach
               </td>
            <td>{{$codex->scriptStyle ? $codex->scriptStyle->style : ''}}</td>

            <td>
               <a href="{{ URL::action([App\Http\Controllers\ManuscriptOriginalCodexController::class, 'show'], $codex->id) }}"
                  title="Assistance anzeigen">
                  <span class="glyphicon glyphicon-eye-open glyphicon-hover"></span>
               </a>
               <a href="{{ URL::action([App\Http\Controllers\ManuscriptOriginalCodexController::class, 'edit'], $codex->id)}}">
                        <span class="btn btn-primary">
                            <span class="glyphicon glyphicon-pencil"></span> Bearbeiten
                        </span>
               </a>
            </td>
         </tr>
      @endforeach
      </tbody>
   </table>

@endsection
