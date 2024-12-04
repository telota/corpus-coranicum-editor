@extends("layouts.master")

@section("title")

<div class="flex-container">
    <div class="flex-item">
        Zotero Übersicht <a href="https://www.zotero.org/groups/265673/" target="_blank">
            <span class="glyphicon glyphicon-link glyphicon-hover"></span>
        </a>
    </div>

    <div class="pull-right">
        <div id="zotero-sync-button">
            <zotero-sync-button></zotero-sync-button>
        </div>
    </div>

</div>
@endsection

@section("content")
<table class="dataTable table table-striped">
    <thead>
        <tr>
            <th>Zotero ID</th>
            <th>Kurzreferenz</th>
            <th>Bibliographische Angaben</th>
            <th>Version</th>
            <th>Letzte Änderung</th>
            <th>Erstellt</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($bibliography as $item)
        <tr>
            <td>{{$item->zotero_key}}</td>
            <td>{{$item->short_citation}}</td>
            <td>{{$item->citation}}</td>
            <td>{{$item->zotero_version}}</td>
            <td>{{$item->updated_at}}</td>
            <td>{{$item->created_at}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Keine Zotero Einträge vorhanden</td>
        </tr>
        @endforelse
    </tbody>
</table>
<p>Hinweis: Tabelle wurde früher über einen lokal abgelegten File erstellt, deswegen beginnt "erstellt" erst ab Juni 2023.</p>
@endsection
