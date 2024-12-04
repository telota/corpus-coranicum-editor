<div id="umwelttext-wrapper-main" class="hide">
    <div id="umwelttext-wrapper">
        <select name="Umwelttexte">
            @forelse ($intertexts as $item)
            <option value="{{ $item['id'] }}">{{ $item['id'] }} {{ $item['titel'] }}</option>
            @empty
            <option value="Keine Umwelttexte vorhanden">Keine Umwelttexte vorhanden</option>
            @endforelse
        </select>
    </div>
</div>
