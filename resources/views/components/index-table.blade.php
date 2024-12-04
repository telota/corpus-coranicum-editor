<table id="{{$id ?? ''}}"
       class="dataTable table table-striped" data-toggle="table" data-row-style="rowStyle">
    <thead>
    <tr>
        @foreach($columns as $column)
            <th>{{$column}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($entities as $entity)
        <tr>
            <x-dynamic-component :component='$rowComponent' :$entity />
        </tr>
    @endforeach
    </tbody>
</table>

