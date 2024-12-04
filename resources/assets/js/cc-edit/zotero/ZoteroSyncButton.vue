<template>
    <div>
        <button :class="['btn', buttonClass]" :disabled="isSyncing" @click="startSync">
            <span class="glyphicon glyphicon-refresh"></span>
            {{ message }}
        </button>
    </div>
</template>
<script type="text/babel">
export default {
  data() {
    return {
      isSyncing: false,
      hasFailed: false,
    };
  },

  computed: {
    message() {
      if (this.hasFailed) {
        return 'Oops. Something went wrong';
      }

      if (this.isSyncing) {
        return 'Zotero wird synchronisiert';
      } else {
        return 'Zotero synchronisieren';
      }
    },

    buttonClass() {
      if (this.isSyncing) {
        return 'btn-warning';
      } else {
        return 'btn-primary';
      }
    },
  },

  methods: {
    startSync() {
      this.isSyncing = true;

      axios
        .post('zotero/sync', {
          _token: $('meta[name="csrf-token"]').attr('content'),
        })
        .then(function(response) {
          location.reload();
        })
        .catch(function(error) {
          this.hasFailed = true;
        });
    },
  },
};
</script>
