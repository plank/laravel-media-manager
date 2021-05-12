<template>
  <div class="mm__results">
    <div v-if="this.$store.state.hideDirectory == false" class="mm__results-grid">
      <div
        v-for="(item, index) in getDir"
        :key="index"
        class="mm__results-single"
        v-bind:class="[cardItem == index ? 'active' : '']"
        v-on:click="showOptions(index, item)"
        v-on:dblclick="openDirectory(item)"
        @contextmenu.prevent.stop="handleClick($event, item)"
      >
        <mmfoldercard :item="item"></mmfoldercard>
      </div>

      <vue-simple-context-menu
        v-if="this.$store.state.haveContextMenu"
        :elementId="'myUniqueId'"
        :options="optionsArray1"
        :ref="'vueSimpleContextMenu'"
        @option-clicked="optionClicked"
      />
    </div>
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
      optionsArray1: [
        {
          name: this.$i18n.t("actions.delete"),
          slug: "delete",
          class: "delete-class",
        },
        {
          type: "divider",
        },
        {
          name: this.$i18n.t("actions.move"),
          slug: "move",
        },
      ],
    };
  },
  methods: {
    handleClick(event, item) {
      if (this.$store.state.haveContextMenu) {
        this.$refs.vueSimpleContextMenu.showMenu(event, item);
      }
    },
    optionClicked(event) {
      this.$store.state.selectedElem.push(event.item);
      if (JSON.stringify(event.option.slug) === '"delete"') {
        this.$store.dispatch("openModalDelete");
      } else if (JSON.stringify(event.option.slug) === '"move"') {
        this.$store.state.selectedDirectory = event.item;
        this.$store.dispatch("openModalMove");
        // EventBus.$emit('open-slide-panel', [event.item]);
      }
    },
    openDirectory: function (value) {
      this.current = value.name;
      this.$store.dispatch("setSelectedDirectory", null);
      this.$store.dispatch("getDirectory", value.name);
    },
    showOptions(index, item) {
      this.cardItem = index;
      this.$store.dispatch("setSelectedDirectory", item);
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
};
</script>
