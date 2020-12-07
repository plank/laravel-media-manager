<template>
  <div class="mm__results">
    <table class="mm-table">
      <thead>
        <tr>
          <th class="mm-table__input" width="40"></th>
          <th width="75">Preview</th>
          <th>Name</th>
          <th>Type</th>
          <th>Upload Date</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(elem, index) in mediaCollection" v-bind:key="index">
          <td class="mm-table__input">
            <input v-on:click="setCurrent($event, elem)" type="checkbox" />
          </td>
          <td>
            <img src="https://via.placeholder.com/75" alt="" />
          </td>
          <td><strong>{{ elem.filename }}</strong></td>
          <td>{{ elem.mime_type }}</td>
          <td>{{ elem.created_at }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { EventBus } from "./../event-bus.js";
import mmcard from "./mm-card";

export default {
  name: "mmlistresults",
  components: {},
  data() {
    return {
      current: null,
      mediaCollection: this.$store.state.mediaCollection,
    };
  },
  methods: {
    // Set Current State And Open Slidepanel
    setCurrent: function (event, id) {
      EventBus.$emit("openSlidepanel", id);
    },
  },
  mounted() {},
  computed: {
    totalSelectedCount() {
      return this.$store.state.totalSelected;
    },
  },
};
</script>
