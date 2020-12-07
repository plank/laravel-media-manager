<template>
  <div class="mm__results">
    <!-- For Each Loop -->
    <div class="mm__results-grid">
      <div v-for="item in mediaCollection" :key="item.id" class="mm__results-single" v-bind:class="{ selected: current === item.id }" v-on:click="pushSelected($event, item)">
        <mmcard :item="item"></mmcard>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "./../event-bus.js";
import mmcard from "./mm-card";

export default {
  name: "mmresults",
  components: {
    mmcard,
  },
  data() {
    return {
      current: null,
      mediaCollection: this.$store.state.mediaCollection,
    };
  },
  methods: {
    // Push selected element to store
    pushSelected: function (event, value) {
      console.log(value);
      event.preventDefault();
      this.current = value.id;;
      this.$store.dispatch("pushSelected", value);
    },
    // Set Current State And Open Slidepanel
    // setCurrent: function (event, id) {
    //   event.preventDefault();
    //   EventBus.$emit("setID", id);
    //   EventBus.$emit("openSlidepanel", id);
    // },
  },
  mounted() {},
  computed: {
    totalSelectedCount() {
      return this.$store.state.totalSelected;
    },
  },
};
</script>
