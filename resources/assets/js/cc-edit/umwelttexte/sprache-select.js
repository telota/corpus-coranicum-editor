import rtlLanguages from './rtl-languages';

$('.custom-select#sprache')
  .select2({
    tags: true,
  })
  .on('change', event => {
    let language = $('.custom-select#sprache').val();

    if (rtlLanguages.includes(language)) {
      $('#sprache-richtung').val('rtl');
    } else {
      $('#sprache-richtung').val('ltr');
    }
  });
