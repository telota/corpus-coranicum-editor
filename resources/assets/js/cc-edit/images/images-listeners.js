let imageMethods = require('./images-methods');

$('.remove-image').on('click', function() {
  imageMethods.removeImageInput(this);
});
