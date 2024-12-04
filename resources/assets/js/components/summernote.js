import addSummernoteToZotero from './summernote-zotero';
import addUmweltTextToSummernote from './summernote-umwelttext';

function summernoteConfig(target) {
  return {
    minHeight: 200,
    toolbar: [
      //[groupname, [button list]]
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['table', ['table']],
      ['insert', ['ltr', 'rtl']],
      ['insert', ['link', 'picture', 'hr']],
      ['view', ['fullscreen', 'codeview']],
      ['help', ['help']],
    ],
    callbacks: {
      onKeyUp: function(e) {
        $(target).val($(target).summernote('code'));
      },
      onBlur: function() {
        $(target).val($(target).summernote('code'));
      },
      onChange: function(contents) {
        $(target).val($(target).summernote('code'));
      },
    },
  };
}

$(function() {
  // Make all textareas a summernote editor
  $('.summernote').summernote(summernoteConfig);
  addSummernoteToZotero();
  addUmweltTextToSummernote();

  // Create a summernote editor on button click
  $('.summernote-activator').on('click', function() {
    let target = $(this).attr('summernote-target');

    $(target).summernote(summernoteConfig(target));
    $(this).siblings('.summernote-deactivator').show();

    addSummernoteToZotero(target);

    addUmweltTextToSummernote(target);

    $(this).hide();
  });
});

$('.summernote-deactivator').on('click', function(){
  let target = $(this).attr('summernote-target');
  $(this).siblings('.summernote-activator').show();
  $(this).hide();
  $(target).summernote('destroy');
})
