import Words from './words';
import TagHelper from './tagHelper';

const ui = $.summernote.ui;

const omittedButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil" style="color:black; background-color:yellow">Omitted</span>',
    tooltip: 'Omitted in manuscript compared to Cairo 1924',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data
        .lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);
      const sRange = $('#transliterationSummernote').summernote('createRange');

      if (range.toString().length > 0) {
        const tag = document.createElement('supplied');

        tag.setAttribute('reason', 'omitted-in-original');
        tag.setAttribute('source', '#cairo_rasm');
        tag.className = 'omitted';
        tag.innerHTML = sRange.toString();

        range.deleteContents();
        range.insertNode(tag);

        for (let i = 0; i < lineList.length; i += 1) {
          if (lineList[i].isActive) {
            Words.saveWords(lineList[i]);
            $('#transliterationSummernote').summernote(
              'code',
              lineList[i].editedText,
            );
          }
        }
      }
    },
  });

  return button.render();
};

const unclearButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil" style="background-color:#FDE9D9"; color:black>Unclear</span>',
    tooltip: 'Unclear',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data
        .lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);
      const sRange = $('#transliterationSummernote').summernote('createRange');

      if (range.toString().length > 0) {
        const tag = document.createElement('unclear');

        tag.className = 'unclear';
        tag.innerHTML = sRange.toString();

        range.deleteContents();
        range.insertNode(tag);

        for (let i = 0; i < lineList.length; i += 1) {
          if (lineList[i].isActive) {
            Words.saveWords(lineList[i]);
            $('#transliterationSummernote').summernote(
              'code',
              lineList[i].editedText,
            );
          }
        }
      }
    },
  });

  return button.render();
};

const illegibleButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil" style="background-color:white; color:grey">Illegible</span>',
    tooltip: 'Illegible, text missing due to physical damage',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data
        .lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);
      const sRange = $('#transliterationSummernote').summernote('createRange');

      if (range.toString().length > 0) {
        const tag = document.createElement('supplied');

        tag.setAttribute('reason', 'illegible');
        tag.setAttribute('source', '#cairo_rasm');
        tag.className = 'illegible';
        tag.innerHTML = sRange.toString();

        range.deleteContents();
        range.insertNode(tag);

        for (let i = 0; i < lineList.length; i += 1) {
          if (lineList[i].isActive) {
            Words.saveWords(lineList[i]);
            $('#transliterationSummernote').summernote(
              'code',
              lineList[i].editedText,
            );
          }
        }
      }
    },
  });

  return button.render();
};

const addedButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil" style="background-color:lawngreen; color:black">Additional</span>',
    tooltip: 'Additional character in manuscript compared to Cairo 1924',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data
        .lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);
      const sRange = $('#transliterationSummernote').summernote('createRange');

      if (range.toString().length > 0) {
        const tag = document.createElement('add');

        tag.setAttribute('type', 'rasm');
        tag.className = 'rasm_added';
        tag.innerHTML = sRange.toString();

        range.deleteContents();
        range.insertNode(tag);

        for (let i = 0; i < lineList.length; i += 1) {
          if (lineList[i].isActive) {
            Words.saveWords(lineList[i]);
            $('#transliterationSummernote').summernote(
              'code',
              lineList[i].editedText,
            );
          }
        }
      }
    },
  });

  return button.render();
};

const variantButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil" style="background-color:#C6D9F1"; color:black>Variant</span>',
    tooltip: 'Variant spelling in manuscript compared to Cairo 1924',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data
        .lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);
      const sRange = $('#transliterationSummernote').summernote('createRange');

      if (range.toString().length > 0) {
        const tag = document.createElement('add');

        tag.setAttribute('type', 'rasm');
        tag.setAttribute('subtype', 'variant');
        tag.className = 'rasm_variant';
        tag.innerHTML = sRange.toString();

        range.deleteContents();
        range.insertNode(tag);

        for (let i = 0; i < lineList.length; i += 1) {
          if (lineList[i].isActive) {
            Words.saveWords(lineList[i]);
            $('#transliterationSummernote').summernote(
              'code',
              lineList[i].editedText,
            );
          }
        }
      }
    },
  });

  return button.render();
};

const modifiedButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil" style="background-color:#4FD1FF; color:black">Modified</span>',
    tooltip: 'Modified, Manipulated, Added, Rectified',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data
        .lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);
      const sRange = $('#transliterationSummernote').summernote('createRange');

      if (range.toString().length > 0) {
        const tag = document.createElement('hi');

        tag.setAttribute('rend', '4_-_multiple_modification');
        tag.className = 'modified';
        tag.innerHTML = sRange.toString();

        range.deleteContents();
        range.insertNode(tag);

        for (let i = 0; i < lineList.length; i += 1) {
          if (lineList[i].isActive) {
            Words.saveWords(lineList[i]);
            $('#transliterationSummernote').summernote(
              'code',
              lineList[i].editedText,
            );
          }
        }
      }
    },
  });

  return button.render();
};

const erasedButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil" style="background-color:red; color:whitesmoke">Erased</span>',
    tooltip: 'Erased',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data
        .lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);
      const sRange = $('#transliterationSummernote').summernote('createRange');

      if (range.toString().length > 0) {
        const tag = document.createElement('del');

        tag.className = 'deleted';
        tag.innerHTML = sRange.toString();

        range.deleteContents();
        range.insertNode(tag);

        for (let i = 0; i < lineList.length; i += 1) {
          if (lineList[i].isActive) {
            Words.saveWords(lineList[i]);
            $('#transliterationSummernote').summernote(
              'code',
              lineList[i].editedText,
            );
          }
        }
      }
    },
  });

  return button.render();
};

const standardButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil" style="color:#4a2081">Standard</span>',
    tooltip: 'Standard manuscript text, compatible with Cairo 1924',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data
        .lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);
      const sRange = $('#transliterationSummernote').summernote('createRange');

      if (range.toString().length > 0) {
        const tag = document.createElement('standard');
        tag.innerHTML = sRange.toString();

        range.deleteContents();
        range.insertNode(tag);

        TagHelper.deleteStandardTags(
          $('#transliterationSummernote').summernote('code'),
        );
        $('#transliterationSummernote').summernote(
          'code',
          TagHelper.deleteDoubleTags(
            TagHelper.deleteStandardTags(
              $('#transliterationSummernote').summernote('code'),
            ),
          ),
        );

        for (let i = 0; i < lineList.length; i += 1) {
          if (lineList[i].isActive) {
            Words.saveWords(lineList[i]);
            $('#transliterationSummernote').summernote(
              'code',
              lineList[i].editedText,
            );
          }
        }
      }
    },
  });

  return button.render();
};

/*
const seperatorButton = () => {
  const button = ui.button({
    contents:
      '<span class="fa fa-pencil">۝</span>',
    tooltip: 'Insert verse-seperator at current cursor position',

    click() {
      const lineList = $('#transliterationSummernote').parent()[0].__vue__._data.lineList;

      const highlight = window.getSelection();
      const range = highlight.getRangeAt(0);

      const tag = document.createElement('pc');
      tag.innerHTML = ' ۝ ';

      range.deleteContents();
      range.insertNode(tag);

      TagHelper.deleteStandardTags($('#transliterationSummernote').summernote('code'));
      $('#transliterationSummernote').summernote('code', TagHelper.deleteDoubleTags(TagHelper.deleteStandardTags($('#transliterationSummernote').summernote('code'))));

      for (let i = 0; i < lineList.length; i += 1) {
        if (lineList[i].isActive) {
          Words.saveWords(lineList[i]);
          $('#transliterationSummernote').summernote('code', lineList[i].editedText);
        }
      }
    },
  });

  return button.render();
};
*/

export default {
  omittedButton,
  unclearButton,
  illegibleButton,
  addedButton,
  variantButton,
  modifiedButton,
  erasedButton,
  standardButton,
};
