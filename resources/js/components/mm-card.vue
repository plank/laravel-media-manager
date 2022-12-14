<template>
  <div
    class="mm__card"
    v-bind:class="{ selected: setSelected }"
    v-on:dblclick="openSelectedMedia(mediaItem)"
    v-on:click="pushSelected(mediaItem)"
  >
    <div class="mm__card-background" :style="setBackground(mediaItem)">
      <div
        class="mm__card-placeholder mm__card-default-placeholder"
        v-if="
        mediaItem.aggregate_type === 'document' ||
        mediaItem.aggregate_type === 'pdf' ||
        mediaItem.aggregate_type === 'audio' ||
        mediaItem.aggregate_type === 'video'
        "
      >
        {{ mediaItem.extension }}
      </div>
    </div>
    <div class="mm__card-infos">
      <h6>{{ mediaItem.filename }}</h6>
      <span class="type">{{ mediaItem.aggregate_type }}</span>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../event-bus.js";
export default {
  name: "mmcard",
  props: ["item", "index"],
  data() {
    return {
      isSelected: false,
      mediaItem: this.item
    };
  },
  methods: {
    openSelectedMedia: function () {
      EventBus.$emit("open-slide-panel", this.index);
    },
    pushSelected: function (value) {
      this.current = value.id;
      this.$store.dispatch("pushSelected", value);
      this.isSelected = !this.isSelected;
      EventBus.$emit("close-slide-panel");
    },
    setBackground: function (item) {
      return "background: url(" + item.conversion_urls[Object.keys(item.conversion_urls)[0]] + ")";
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
