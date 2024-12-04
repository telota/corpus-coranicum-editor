@props(['entity','action','page'])
@php
    $image_url=\App\Http\Controllers\ManuscriptPageImageController::makeImageLink($entity->image_link, true);
    if($action == \App\Enums\FormAction::Edit || $action == \App\Enums\FormAction::Create){
    $image_count = $entity->page ? sizeof($entity->page->images) : 0;
    $max_sort = $action == \App\Enums\FormAction::Edit  ? $image_count : $image_count + 1;
    $sort_select = collect(range(1,$max_sort))->mapWithKeys(fn($n)=>[$n=>$n]);
    }else{
        $sort_select = collect([]);
    }

@endphp
@if($action == \App\Enums\FormAction::Edit)
    <div class="panel panel-default">
        <div class="panel-heading">
            <label class='panel-title'>
                Original Filename
            </label>
        </div>
        <div class="panel-body">
            <div class="input-group">
                {{$entity->original_filename}}
            </div>
        </div>
    </div>
@endif
@if($entity->page->manuscript->no_images)
    <div class="panel panel-default">
        <div class="panel-heading">
            <label class="panel-title">Image Rights</label>
        </div>
        <div class="panel-body space-between">
            This image is set to private use only because images are restricted on the manuscript.
        </div>
    </div>
    <input type="hidden" name="private_use_only" value='1'>
@else
    <x-form.radio-buttons name='private_use_only' label='Image Rights'
                          :options='collect([0=>"Publicly Shareable", 1=>"Internal Use Only"])'
                          :selected='$entity->private_use_only == null ? 0 : 1' :$action />

@endif
<x-form.image :$entity label='Digilib Image' :url='$image_url'
              :action='$action == \App\Enums\FormAction::Create ? $action : \App\Enums\FormAction::Show'
              :create='false' />
<x-form.text :$entity label='Original Filename' dbField='original_filename' :$action :create='false' :edit='false' />
<x-form.file :$entity :label='$entity->image_link ? "Upload a replacement file" : "Please choose a file"'
             name='single_file' path='' :$action :show='false' />
<x-form.text :$entity label='Manuscript Default Credit for Images:' dbField='ms_credit_line_image'
             :action='\App\Enums\FormAction::Show'
              />
<x-form.text :$entity label='Image Credit (if different from the Manuscript Credit for Images)' dbField='credit_line_image' :$action
             placeholder='e.g. Qatar National Library, Heritage Library' />
<x-form.text :$entity
             label='External Image Link'
             dbField='image_link_external' :$action
             placeholder='e.g. http://gallica.bnf.fr/ark:/12148/btv1b8415205n.r=arabe%20326' />
<x-form.select :$entity label='Sort Order (1 is first and primary image)' name='sort' :$action :value='$entity->sort'
               :options='$sort_select' />
<x-form.text :$entity
             label='External IIIF (used in lieu of Digilib)'
             dbField='iiif_external' :$action
             placeholder='e.g.https://content.staatsbibliothek-berlin.de/dc/PPN1778277071-00000038/info.json' />
<x-form.image :$entity
              label='External Thumbnail (used in lieu of Digilib)'
              dbField='thumbnail_external' :$action
              placeholder='e.g.https://content.staatsbibliothek-berlin.de/dc/PPN1778277071-00000038/full/300,/0/default.png'
/>
<x-history :$entity :$action />
