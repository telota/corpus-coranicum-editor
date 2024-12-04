<?xml version="1.0" encoding="UTF-8"?>
<mets:mets xmlns:mets="http://www.loc.gov/METS/" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.loc.gov/METS/ http://www.loc.gov/standards/mets/mets.xsd" xmlns:dc="http://purl.org/dc/elements/1.1/">
    <mets:metsHdr CREATEDATE="{{ now()->toIso8601String() }}">
        <mets:agent ROLE="CREATOR" TYPE="INDIVIDUAL">
            <mets:name>Claus Franke</mets:name>
        </mets:agent>
    </mets:metsHdr>

    {{-- Schleife durch jedes Manuskript im Array --}}
    @foreach($data as $manuscript)
        <mets:dmdSec ID="dmd_manuscript_{{ $manuscript['manuscript_image_id'] }}">
            <mets:mdWrap MDTYPE="DC">
                <mets:xmlData>
                    <dc:title>manuscript-id {{ $manuscript['manuscript_id'] }} page-id {{ $manuscript['manuscript_page_id']}} page and folio{{ $manuscript['manuscript_page_folio'] }}{{ $manuscript['manuscript_page_side'] }}</dc:title>
                    <dc:identifier>{{ $manuscript['manuscript_image_id'] }}</dc:identifier>
                    <dc:format>image</dc:format>
                    <dc:source>{{ $manuscript['original_filename'] }}</dc:source>
                    <dc:type>manuscript</dc:type>
                    <dc:rights>{{ $manuscript['private_use_only'] ? 'Private Use Only' : 'Public' }}</dc:rights>
                </mets:xmlData>
            </mets:mdWrap>
        </mets:dmdSec>

        <mets:fileSec>
            <mets:fileGrp USE="archive">
                <mets:file ID="FILE{{ $manuscript['manuscript_image_id'] }}" MIMETYPE="{{ $manuscript['mime_type']}}">
                    <mets:FLocat LOCTYPE="URL" xlink:href="{{ $manuscript['digilib_image'] }}" />
                </mets:file>
            </mets:fileGrp>
        </mets:fileSec>
    @endforeach

    {{-- Strukturelle Map der Manuskripte --}}
    <mets:structMap>
        @foreach($data as $manuscript)
            <mets:div TYPE="Manuscript" DMDID="dmd_manuscript_{{ $manuscript['manuscript_image_id'] }}">
                <mets:div TYPE="Page" ID="PAGE{{ $manuscript['manuscript_page_id'] }}">
                    <mets:fptr FILEID="FILE{{ $manuscript['manuscript_image_id'] }}" />
                </mets:div>
            </mets:div>
        @endforeach
    </mets:structMap>
</mets:mets>