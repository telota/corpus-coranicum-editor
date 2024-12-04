import { QuranMappings } from './QuranMappings';
import $ from 'jquery';
import { diacriticListeners } from './manuscript-diacritics';
import { CoordinateSelect } from './CoordinateSelect';
import { Variants } from './Variants';

diacriticListeners();

if ($('#quran-mappings-edit').length) {
  new QuranMappings('quran-mappings-edit');
}

const elements = $('#reading-variant-verse').get();
if (elements.length == 1) {
  new Variants('varianten');
}

$('#logout-button').on('click', function(event) {
  event.preventDefault();
  console.log('hey there!');
  $('#logout-form').trigger('submit');
});

