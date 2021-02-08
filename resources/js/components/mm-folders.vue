<template>
  <div class="mm__results">
    <!-- <div v-if="this.current">
          <a v-on:click="goBack($event)" href="">BACK</a>
      </div> -->

    <!-- For Each Loop -->

    <!-- <div class="mm__results-grid" v-if="getDir.length"> -->
    <div class="mm__results-grid">
      <div
        v-for="(item, index) in getDir"
        :key="index"
        class="mm__results-single"
        v-bind:class="[cardItem == index ? 'active' : '']"
        v-on:click="showOptions(index, item)"
        v-on:dblclick="openDirectory($event, item)"
      >
        <mmfoldercard :item="item"></mmfoldercard>
      </div>
    </div>
    <!-- <div class="mm__results-empty" v-else>
      <h2>Empty Folder Illustration</h2>
    </div> -->
  </div>
</template>

<script>
import mmfoldercard from "./mm-card-folder";

export default {
  name: "mmfolders",
  components: {
    mmfoldercard,
  },
  data() {
    return {
      current: null,
      cardItem: null,
      // directoryCollection: this.$store.state.directoryCollection
    };
  },
  methods: {
    // Open Directory
    // Set activeDirectory and open in relation
    openDirectory: function (event, value) {
      event.preventDefault();
      this.current = value;
      this.$store.dispatch("getDirectory", value);
      // Retrieve files
      this.$store.dispatch("getMediaInDirectory", value);
    },
    showOptions(index, item) {
      this.cardItem = index;
      this.$store.dispatch("setSelectedDirectory", item);
    },
    goBack($event) {
      $event.preventDefault();
      let directoryTarget = null;
      const directoryLevel = this.current.split("/");

      if (directoryLevel.length > 1) {
        // Get second last item on arrau
        directoryTarget = directoryLevel[directoryLevel.length - 2];
      } else {
        directoryTarget = "";
      }

      this.openDirectory($event, directoryTarget);
    },
  },
  computed: {
    getDir() {
      return this.$store.getters.getDirectory;
    },
  },
  mounted() {
    this.$store.dispatch("getDirectory");
  },
  getterDirectory() {
    return this.$store.getters.directoryCollection;
  },
};
</script>
