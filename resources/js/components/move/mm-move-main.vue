<template>
  <div>
    <ul class="mm__move-folder-list">
      <li
        v-if="getDir.length || getDir.length == 0"
        class="mm__move-back"
        v-on:click.prevent="goBack()"
      >
        <a href="">{{ $t("actions.back") }}</a>
      </li>
      <li
        v-for="(item, index) in getDir"
        :key="index"
        v-bind:class="[folderIndex == index ? 'active' : '']"
      >
        <div class="mm__move-single">
          <div class="mm__move-folder-title">
            <a v-on:click.prevent="selectElement(item, index)" href="#">{{
              item.name | clearname
            }}</a>
          </div>
          <div class="mm__move-folder-handler">
            <a v-on:click.prevent="goDeeper(item.name)" href="#">Enter</a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { EventBus } from "../../event-bus.js";

export default {
  name: "mmmovemain",
  components: {},
  data() {
    return {
      current: null,
      folderIndex: null,
    };
  },
  methods: {
    goBack() {
      let directoryTarget = "";
      const directoryLevel = this.current.split("/");

      if (directoryLevel.length > 1) {
        directoryTarget = directoryLevel[directoryLevel.length - 2];
      }

      this.$store.dispatch("clearModalError");
      this.current = directoryTarget;
      this.$store.dispatch("getMoveDirectory", directoryTarget);
    },
    selectElement: function (value, index) {
      this.folderIndex = index;
      EventBus.$emit("allowMove", value);
    },
    goDeeper: function (directoryName) {
      this.$store.dispatch("clearModalError");
      this.current = directoryName;
      this.$store.dispatch("getMoveDirectory", directoryName);
    },
  },
  watch: {
    folderIndex(){
      this.$store.dispatch("clearModalError");
    }
  },
  filters: {
    clearname: function (name) {
      name = name.split("/");
      return name[name.length - 1];
    },
  },
  mounted() {
    this.$store.dispatch("getMoveDirectory");
  },
  computed: {
    getDir() {
      return this.$store.getters.getMoveDirectory;
    },
  },
};
</script>
