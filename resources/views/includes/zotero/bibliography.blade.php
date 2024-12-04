<table class="dataTable table table-striped">
    <thead>
    <tr>
        <th>Zotero ID</th>
        <th>Kurzreferenz</th>
        <th>Bibliographische Angaben</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $key => $values)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $values["short"] }}</td>
            <td>{{ $values["long"] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
