
/**
 * Add a new image, depending on the route
 * @param route
 */

const ajaxRoot = [process.env.MIX_APP_SUBPATH, '/ajax'].join('');

/**
 * Remove an image input
 * @param button
 */
exports.removeImageInput = function(button) {
  $(button)
    .parents('.input-image')
    .remove();
};
