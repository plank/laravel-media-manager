<template>
  <div id="breadcrumb">
    <ul>
      <li v-if="this.createBreadcrumb.length > 0">
        <a v-on:click.prevent="openRootDirectory()" href="#">home</a>
      </li>
      <li v-for="(elem, index) in breadCrumb" :key="index">
        <span v-if="elem">
          <span v-if="index != Object.keys(createBreadcrumb).length - 1">
            <a v-on:click.prevent="openDirectory({ index, elem })" href="#">{{ elem }}</a>
          </span>
          <span v-else>
            <a href="#">{{ elem }}</a>
          </span>
        </span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "mmbreadcrumb",
  props: ["item", "resetPageNumber"],
  methods: {
    openRootDirectory: function () {
      this.$store.dispatch("getDirectory",{pageNumber: 1}).then( () => {
            this.$store.dispatch("resetSelected");
            this.resetPageNumber();
      });
    },
    openDirectory: function (directoryPath) {
      const newBreadcrumbArray = this.createBreadcrumb;
      newBreadcrumbArray.length = directoryPath.index + 1;
      const qs = Object.keys(newBreadcrumbArray)
        .map((key) => `${newBreadcrumbArray[key]}`)
        .join("/");
      this.$store.dispatch("getDirectory", { directory: qs, pageNumber: 1 }).then( () => {
            this.$store.dispatch("resetSelected");
            this.resetPageNumber();
      });

    },
  },
  computed: {
    breadCrumb() {
      if (this.createBreadcrumb.length > 0) {
        return this.createBreadcrumb;
      }
    },
    createBreadcrumb() {
      let entryArray = [];
      if (this.$store.getters.getCurrentDirectory) {
        const currentDirectory = this.$store.getters.getCurrentDirectory + "";
        entryArray = currentDirectory.split("/");
      }
      return entryArray;
    },
  },
};
</script>
