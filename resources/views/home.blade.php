@extends("layouts.master")

@section("title")

    <div class="jumbotron">
        <h1>CCedit</h1>
        <p>Fragen an: <a href="mailto:coranicum-technik@bbaw.de">coranicum-technik@bbaw.de</a></p>
    </div>

@endsection

@section("content")
    @include("includes.news")
    <x-menu :type="'main_menu'"/>
@endsection
