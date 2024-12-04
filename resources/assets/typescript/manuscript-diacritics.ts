import $ from 'jquery';

export function diacriticListeners() {

  $('#diacritic_classical_arabic').on('click', function() {
    const ids = [
      3, 4, 5, 6, 8, 10, 12, 14, 16, 18, 20, 21, 25, 29, 32,
    ];
    $('[id^=diacritics_]').prop('checked', false);
    ids.forEach(id => $(`#diacritics_${id}`).prop('checked', true));
  });

  $('#diacritic_maghrebi').on('click', function() {
    const ids = [
      3, 4, 5, 6, 8, 10, 12, 14, 16, 18, 20, 22, 23, 29, 32,
    ];
    $('[id^=diacritics_]').prop('checked', false);
    ids.forEach(id => $(`#diacritics_${id}`).prop('checked', true));
  });

  $('#diacritic_ancient').click(function() {
    const ids = [
      3, 4, 5, 6, 8, 10, 12, 14, 16, 18, 20, 21, 24, 29, 32,
    ];
    $('[id^=diacritics_]').prop('checked', false);
    ids.forEach(id => $(`#diacritics_${id}`).prop('checked', true));
  });

  $('#diacritic_clear').on('click', function() {
    $('[id^=diacritics_]').prop('checked', false);
  });
}
