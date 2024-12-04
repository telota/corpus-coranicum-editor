$('select.free-text-select').select2({ tags: true });

exports.refreshVueSelects = function(select2config = null) {
  const deleteSelector = $('.hide-select select.select2-hidden-accessible');
  const currentSelector = $('.current-select select');

  if (deleteSelector.length) {
    deleteSelector.select2('destroy');
  }

  currentSelector.select2(select2config);
};
