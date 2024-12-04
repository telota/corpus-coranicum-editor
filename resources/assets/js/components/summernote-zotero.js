// Add zotero button

function addSummernoteToZotero(selector = '') {
  const zoteroButton =
    '<button ' +
    'type="button" ' +
    'class="btn btn-default btn-sm btn-small zotero" ' +
    'title="Zotero Reference" ' +
    'data-event="something" ' +
    'tabindex="-1">Zotero</button>';

  const zoteroGroup = `<div class="zotero-group btn-group">${zoteroButton}</div>`;

  // add summernote to a single instance
  if (selector.length) {
    $(zoteroGroup).appendTo($(selector)
      .siblings('.note-editor')
      .children('.note-toolbar'));
  } else {
    // Add zotero button to all summernote instances
    $(zoteroGroup).appendTo($('.note-toolbar'));
  }

  $('.zotero').on('click', function(){
    const highlight = window.getSelection();

    const highlightLength = highlight.toString().length;

    const highlightString = highlight.toString();
    // if (highlight && highlight.rangeCount > 0) {
    const range = highlight.getRangeAt(0);
    // }
    const zoteroDialog = $('#zotero-wrapper').dialog({
      position: {
        my: 'center',
        at: 'center',
        of: $(this).parents('.note-editor'),
      },
      width: '82%',
      title: 'Zitation auswählen',
      autoOpen: false,
      close() {
        $(this).dialog('destroy');
      },
      buttons: {
        Ok() {
          const zoteroKey = $('.ui-dialog select').val();

          const shortRef = $('.ui-dialog select option:selected').attr('cite');

          const anchor = document.createElement('a');
          const ref = document.createAttribute('href');
          ref.value = `https://www.zotero.org/groups/corpuscoranicum_pub/items/itemKey/${zoteroKey}`;
          anchor.setAttributeNode(ref);

          const zot = document.createAttribute('zotero');
          zot.value = zoteroKey;
          anchor.setAttributeNode(zot);

          if (highlightLength == 0) {
            anchor.innerHTML = shortRef;
          } else {
            anchor.innerHTML = highlightString;
          }

          anchor.className = 'zotero';

          range.deleteContents();
          range.insertNode(anchor);

          $(this).dialog('close');
        },

        Cancel() {
          $(this).dialog('close');
        },
      },
    });

    zoteroDialog.dialog('open');
  });
}

export default addSummernoteToZotero;
