function addUmweltTextToSummernote(selector = '') {
  let umwelttextButton =
    '<button ' +
    'type="button" ' +
    'class="btn btn-default btn-sm btn-small umwelttext" ' +
    'title="Add Umwelttext" ' +
    'data-event="something" ' +
    'tabindex="-1">Umwelttext</button>';

  let umwelttextGroup =
    '<div class="umwelttext-group btn-group">' + umwelttextButton + '</div>';

  // add summernote to a single instance
  if (selector.length) {
    $(umwelttextGroup).appendTo(
      $(selector)
        .siblings('.note-editor')
        .children('.note-toolbar'),
    );
  }

  // Make adding "Umwelttexte" available through a button button to all summernote instances
  else {
    $(umwelttextGroup).appendTo($('.note-toolbar'));
  }

  $('.umwelttext').on('click', function (event) {

    let highlight = window.getSelection();

    let highlightLength = highlight.toString().length;

    let highlightString = highlight.toString();

    let range = highlight.getRangeAt(0);

    let umwelttextDialog = $('#umwelttext-wrapper').dialog({
      position: {
        my: 'center',
        at: 'center',
        of: $(this).parents('.note-editor'),
      },
      width: '82%',
      title: 'Zitation auswählen',
      autoOpen: false,
      close: function () {
        $(this).dialog('destroy');
      },
      buttons: {
        Ok: function () {
          let textID = $('.ui-dialog select')
            .val();

          let anchor = document.createElement('a');
          let ref = document.createAttribute('href');
          ref.value =
            'http://corpuscoranicum.de/kontexte/index/intertext/' + textID;
          anchor.setAttributeNode(ref);

          if (highlightLength == 0) {
          } else {
            anchor.innerHTML = highlightString;
          }

          anchor.className = 'umwelttext';

          range.deleteContents();
          range.insertNode(anchor);

          $(this).dialog('close');
        },

        Cancel: function () {
          $(this).dialog('close');
        },
      },
    });
    umwelttextDialog.dialog('open');
  });
}

export default addUmweltTextToSummernote;
