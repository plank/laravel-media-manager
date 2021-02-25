<template>
  <div id="breadcrumb">
    <ul>
      <li v-if="this.createBreadcrumb.length > 0">
        <a v-on:click="openRootDirectory($event, '/')" href="#">...</a>
      </li>
      <li v-for="(elem, index) in this.createBreadcrumb" :key="index" v-if="elem">
        <span v-if="index != Object.keys(createBreadcrumb).length - 1">
          <a v-on:click="openDirectory($event, { index, elem })" href="#">{{ elem }}</a>
        </span>
        <span v-else>
          <a href="#">{{ elem }}</a>
        </span>
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
      breadcrumbMarkup: null
    };
  },
  methods: {
    openRootDirectory: function ($event, value) {
      $event.preventDefault();
      this.$store.dispatch('GET_DIRECTORY', value);
    },
    openDirectory: function ($event, value) {
      $event.preventDefault();
      const newBreadcrumbArray = this.createBreadcrumb;
      newBreadcrumbArray.length = value.index + 1;
      const qs = Object.keys(newBreadcrumbArray)
        .map((key) => `${newBreadcrumbArray[key]}`)
        .join('/');
      this.$store.dispatch('GET_DIRECTORY', qs);
    }
  },
  computed: {
    createBreadcrumb () {
      let entryArray = null;
      if (this.$store.getters.GET_CURRENT_DIRECTORY) {
        entryArray = this.$store.getters.GET_CURRENT_DIRECTORY.split('/');
      } else {
        entryArray = [];
      }
      return entryArray;
    }
  },
  watch: {},
  mounted () {}
};
</script>
