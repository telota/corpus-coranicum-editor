<template>
  <div>
    <select name='page-select' id='page-select' class='btn' v-model='selected'>
      <option v-for='(folio, id) in folios' :key='id' :value='id'>
        {{ folio }}
      </option>
    </select>
    <a :href='pageUrl'>
      <button class='btn btn-primary'>
        <span class='glyphicon glyphicon-book'></span>
        Go to Page
      </button>
    </a>
  </div>
</template>

<script>
export default {
  name: 'ManuskriptseitenSelect',
  props: ['current', 'folios', 'manuscriptId', 'pageId', 'urlbase'],
  data() {
    return {
      selected: this.current,
    };
  },
  computed: {
    pageUrl() {
      let newUrl = this.urlbase.toString();
      console.log(newUrl);

      if (this.manuscriptId) {
        newUrl = newUrl.replace('manuscript_id', this.manuscriptId);
      }

      newUrl = newUrl.replace('page_id', this.selected);

      console.log('here is the selected', this.selected);
      console.log('here is the new url,', newUrl);

      return newUrl;
    },
  },
};
</script>
