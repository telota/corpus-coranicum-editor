window.Clipboard = require('clipboard');
window.ajaxRoot = [process.env.MIX_APP_SUBPATH, "/ajax"].join();

require('./components/summernote');
require('./components/summernote-zotero');
require('./components/datatables');
require('./components/select2');
require('./components/datatimepicker');
require('./components/delete-record');
require('./components/jcrop');

require('./components/Modals');

require('./cc-edit/transliteration-editor/vue');
require('./cc-edit/images/images-listeners');
require('./cc-edit/leser/leser-listeners');
require('./cc-edit/manuskriptseiten/manuskriptseiten-select');
require('./cc-edit/zotero/zotero');
require('./cc-edit/umwelttexte/sprache-select');
