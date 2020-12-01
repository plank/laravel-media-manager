<template>
  <button v-on:click="increment()" class="btn btn-add">
    <i class="i-add"></i>
  </button>
</template>

<script>
import { EventBus } from "./../event-bus.js";

export default {
  name: "mmaddbutton",
  data() {
    return {};
  },
  mounted() {},
  methods: {
    increment: function () {
      EventBus.$emit("increment");
    },
  },
};
</script>
