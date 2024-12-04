var leserMethods = require('./leser-methods');
const $ = require('jquery');

$('#add-leser').on('click', function() {
  leserMethods.addLeserInput();
});

$('.remove-leser').on('click', function() {
  leserMethods.removeLeserInput(this);
});

$('#add-alias').on('click', function() {
  leserMethods.addAliasInput();
});

$('.remove-alias').on('click', function() {
  leserMethods.removeAliasInput(this);
});
