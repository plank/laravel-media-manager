<template>
  <div
    class="mm__card"
    v-bind:class="{ selected: setSelected }"
    v-on:dblclick="openSelectedMedia(item)"
    v-on:click="pushSelected(item)"
  >
    <div class="mm__card-background" :style="setBackground(item)">
      <div
        class="mm__card-placeholder mm__card-default-placeholder"
        v-if="
          item.aggregate_type === 'document' ||
          item.aggregate_type === 'pdf' ||
          item.aggregate_type === 'audio' ||
          item.aggregate_type === 'video'
        "
      >
        {{ item.extension }}
      </div>
    </div>
    <div class="mm__card-infos">
      <h6>{{ item.filename }}</h6>
      <span class="type">{{ item.aggregate_type }}</span>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../event-bus.js";
export default {
  name: "mmcard",
  props: ["item"],
  data() {
    return {
      isSelected: false,
    };
  },
  methods: {
    openSelectedMedia: function (item) {
        EventBus.$emit("open-slide-panel", item);
    },
    pushSelected: function (value) {
      this.current = value.id;
      this.$store.dispatch("pushSelected", value);
      this.isSelected = !this.isSelected;
    },
    setBackground: function (item) {
      return "background: url(" + item.conversion_urls[0] + ")";
    },
  },
  computed: {
    setSelected: function (item) {
      const index = this.$store.state.selectedElem.findIndex(
        (elem) => elem.id === item.item.id
      );
      if (index !== -1) {
        return true;
      }
    },
  },
};
</script>
