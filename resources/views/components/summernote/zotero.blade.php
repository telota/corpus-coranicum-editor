<div id="zotero-wrapper-main" class="hide">
    <div id="zotero-wrapper">
        <select name="Literatur">
            @forelse ($zotero as $item)
            <option value="{{ $item['zotero_key'] }}" cite="{{ $item['short_citation'] ?? "Keine Kurzreferenz verfügbar" }}">{{ $item['citation'] }}</option>
            @empty
            <option value="Keine Literatur vorhanden">Keine Literatur vorhanden</option>
            @endforelse
        </select>
    </div>
</div>
