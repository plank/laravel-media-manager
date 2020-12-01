<template>
  <div class="mm__results">
    <table>
      <thead>
        <tr>
          <th></th>
          <th width="75">Preview</th>
          <th>Name</th>
          <th>Type</th>
          <th>Upload Date</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="elem in collection">
          <td>
            <input type="checkbox" />
          </td>
          <td>
            <img src="https://via.placeholder.com/75" alt="" />
          </td>
          <td>{{ elem.name }}</td>
          <td>{{ elem.name }}</td>
          <td>{{ elem.name }}</td>
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
      collection: [
        { id: 1, name: "item 1" },
        { id: 2, name: "item 2" },
        { id: 3, name: "item 3" },
        { id: 4, name: "item 3" },
        { id: 5, name: "item 3" },
        { id: 6, name: "item 3" },
        { id: 7, name: "item 3" },
        { id: 8, name: "item 3" },
        { id: 9, name: "item 3" },
      ],
    };
  },
  methods: {
    // Set Current State And Open Slidepanel
    setCurrent: function (event, id) {
      event.preventDefault();
      this.current = id;
      EventBus.$emit("openSlidepanel", this.current);
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
