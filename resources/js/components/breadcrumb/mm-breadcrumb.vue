<template>
  <div id="breadcrumb">
    <ul>
      <li v-if="this.createBreadcrumb.length > 0">
          <a v-on:click="openDirectory($event, '/')" href="#">...</a>
      </li>
      <li v-for="(elem, index) in this.createBreadcrumb" :key="index" v-if="elem">
        <a v-on:click="openDirectory($event, elem)" href="#">{{ elem }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'mmbreadcrumb',
  props: ['item'],
  data () {
    return {
      isSelected: false,
      breadcrumbElem: null,
      breadcrumbMarkup: null
    };
  },
  methods: {
    openDirectory: function (event, value) {
      event.preventDefault();
      this.current = value;
      this.$store.dispatch('getDirectory', value);
    }
  },
  computed: {
    createBreadcrumb () {
      let entryArray = null;
      if (this.$store.getters.getCurrentDirectory) {
        entryArray = this.$store.getters.getCurrentDirectory.split('/');
      } else {
        entryArray = [];
      }
      return entryArray;
    }
  },
  watch: {
  },
  mounted () {
    this.breadcrumbElem = this.$store.state.getCurrentDirectory;
  }
};
</script>
