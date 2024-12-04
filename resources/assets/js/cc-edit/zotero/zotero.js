import ZoteroSyncButton from './ZoteroSyncButton.vue';

if ($('#zotero-sync-button').length) {
  new Vue({
    el: '#zotero-sync-button',
    components: {
      'zotero-sync-button': ZoteroSyncButton,
    },
  });
}
