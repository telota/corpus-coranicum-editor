<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Authors</div>
    </div>
    @foreach(['metadata','transliteration','image','assistance'] as $role)
        <x-form.authors :entity='$manuskript' :$role module='manuscript'
                        :action='\App\Enums\FormAction::Edit' />
    @endforeach
</div>