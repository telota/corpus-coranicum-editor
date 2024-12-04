@extends("layouts.master")

@section("title")
  <h1>Oxygen Xml Einrichtung für Nutzende</h1>
@endsection

@section("content")
  <style type="text/css">
    code{white-space: pre-wrap;}
    span.smallcaps{font-variant: small-caps;}
    span.underline{text-decoration: underline;}
    div.column{display: inline-block; vertical-align: top; width: 50%;}
  </style>
  All xml files in corpus coranicum are edited in oxygen.

  <ol>
    <li>Clone the git repository: <code>https://gitup.uni-potsdam.de/TELOTA/cluster-mittelalter/corpus-coranicum/corpus_coranicum_xml_files</code></li>
    <li>Edit the project in oxygen</li>
    <li>After making changes, commit your changes and push to the master branch.</li>
  </ol>
  Note: at the moment Corpus Coranicum does not read in these changes. That still needs to be implemented (Marcus Lampert).
@endsection