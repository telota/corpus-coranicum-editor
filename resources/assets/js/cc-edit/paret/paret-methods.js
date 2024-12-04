let ajaxRoot = require('../../components/variables').ajaxRoot;

exports.getParetTransliteration = function() {
  let textstellen = {};

  $('.input__textstelle').each(function(i, textstelle) {
    textstellen[i] = {};

    textstellen[i]['sure_s'] = $(textstelle)
      .find('#sure_s')
      .val();
    textstellen[i]['vers_s'] = $(textstelle)
      .find('#vers_s')
      .val();
    textstellen[i]['sure_e'] = $(textstelle)
      .find('#sure_e')
      .val();
    textstellen[i]['vers_e'] = $(textstelle)
      .find('#vers_e')
      .val();
  });

  $.ajax({
    url: ajaxRoot + '/ajax/parettransliteration',
    type: 'POST',
    data: {
      texstellen: JSON.stringify(textstellen),
      _token: $('meta[name="csrf-token"]').attr('content'),
    },
    dataType: 'json',
    success: function(data) {
      $('#paret-transliteration').html(data['koranstellenView']);
    },
    error: function(xhr, status, error) {
      console.log(xhr.responseText);
    },
  });
};
