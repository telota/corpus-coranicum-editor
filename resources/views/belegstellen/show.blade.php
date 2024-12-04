@extends("layouts.master")
@section("title")
   Belegstellenkategorie
   <a href="{{ URL::action([App\Http\Controllers\BelegstellenKategorieController::class, 'create'])}}">
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
         <th scope="col"></th>
      </tr>
      </thead>
      <tbody>
      @foreach($belegstellenKategorie as $kategorie)
         <tr>
            <td>{{$kategorie->id}}</td>
            <td>{{$kategorie->name}}</td>
            <td>
            @foreach($belegstellenKategorie as $oberkategorie)
               @if($oberkategorie->id == $kategorie->supercategory)
            {{$oberkategorie->name}} (ID: {{$oberkategorie->id}})
               @endif
            @endforeach
               </td>
            <td>
               <a href="{{ URL::action([App\Http\Controllers\BelegstellenKategorieController::class, 'edit'], $kategorie->id)}}">
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