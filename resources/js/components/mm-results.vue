<template>
  <div class="mm__results">
    <div class="mm__results-grid">
      <div
        v-for="item, index in getMediaArray"
        :key="item.id"
        class="mm__results-single"
        @contextmenu.prevent.stop="handleClick($event, item)"
      >
        <mmcard :data-type="item.aggregate_type" :item="item" :index="index"></mmcard>
      </div>
      <div
        class="mm__search-no-result"
        v-if="getMediaArray.length == 0 && this.$store.state.hideDirectory"
      >
        <h3>{{ $t("search.no_result") }}</h3>
      </div>
    </div>
    <vue-simple-context-menu
      v-if="this.$store.state.haveContextMenu"
      :elementId="'CardElement'"
      :options="optionsArray1"
      :ref="'vueSimpleContextMenu'"
      @option-clicked="optionClicked"
    />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { EventBus } from "../event-bus.js";
import mmcard from "./mm-card";

export default {
  name: "mmresults",
  components: {
    mmcard,
  },
  data() {
    return {
      mediaCollection: this.$store.state.mediaCollection,
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
          name: this.$i18n.t("actions.more_details"),
          slug: "details",
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
      } else if (JSON.stringify(event.option.slug) === '"details"') {
        this.$store.dispatch("openSelectedMedia", {
          media: event.item
        });
      }
    },
  },
  computed: {
    ...mapGetters(['getMediaArray']),
  },
};
</script>
