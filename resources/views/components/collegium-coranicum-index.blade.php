@props(['entity'])
@php($category=\App\Enums\Category::CollegiumCoranicum)
<x-veranstaltung-index :$entity :$category />
