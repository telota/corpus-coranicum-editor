
const ajaxRoot = [process.env.MIX_APP_SUBPATH, '/ajax'].join('');
/**
 * Add new leser input
 */
exports.addLeserInput = function () {
  $.ajax({
    url: ajaxRoot + '/addleser',
    type: 'POST',
    data: {
      counter: $('.leser-input').length + 1,
      _token: $('meta[name="csrf-token"]').attr('content'),
    },
    dataType: 'json',
    success: function (data) {
      $(data.selectForm).insertBefore('#add-leser');
      $('.remove-leser').bind('click', function () {
        exports.removeLeserInput(this);
      });

      $('.input-leser select').select2();
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
    },
  });
};

/**
 * Remove reader input
 * @param button
 */
exports.removeLeserInput = function (button) {
    $(button).parents('.leser-input').remove();
};

/**
 * Add alias input for reader
 */
exports.addAliasInput = function () {
  $.ajax({
    url: window.ajaxRoot + '/ajax/addalias',
    type: 'POST',
    data: {
      counter: $('.input-alias').length + 1,
      _token: $('meta[name="csrf-token"]').attr('content'),
    },
    dataType: 'json',
    success: function (data) {
      $(data.inputForm).insertBefore('#add-alias');
      $('.remove-alias').bind('click', function () {
        exports.removeAliasInput(this);
      });
    },
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
    },
  });
};

/**
 * Remove reader alias input
 * @param button
 */
exports.removeAliasInput = function (button) {
  $(button).parents('.input-alias').remove();
};
