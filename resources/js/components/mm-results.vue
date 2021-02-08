<template>
  <div class="mm__results">
    <!-- For Each Loop -->
    <div class="mm__results-grid">
      <div v-for="item in getMedia" :key="item.id" class="mm__results-single">
        <mmcard :item="item"></mmcard>
      </div>
    </div>
  </div>
</template>

<script>
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
    };
  },
  methods: {},
  mounted() {},
  computed: {
    getMedia() {
      return this.$store.state.mediaCollection;
    },
  },
};
</script>
