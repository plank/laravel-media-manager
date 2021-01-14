<template>
  <div class="mm__results">
    <!-- For Each Loop -->
    <div class="mm__results-grid">
      <div
        v-for="item in getDir"
        :key="item.id"
        class="mm__results-single"
        v-on:click="openDirectory($event, item)"
      >
        <mmfoldercard :item="item"></mmfoldercard>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex';
import { EventBus } from '../event-bus.js';
import mmfoldercard from './mm-card-folder';

export default {
  name: 'mmfolders',
  components: {
    mmfoldercard
  },
  data () {
    return {
      current: null
      // directoryCollection: this.$store.state.directoryCollection
    };
  },
  methods: {
    // Open Directory
    // Set activeDirectory and open in relation
    openDirectory: function (event, value) {
      event.preventDefault();
      this.current = value.id;
      this.$store.dispatch('getDirectory', value);
    }
  },
  computed: {
    getDir () {
      return this.$store.getters.getDirectory;
    }
  },
  mounted () {
    this.$store.dispatch('getDirectory');
  },
  getterDirectory () {
    return this.$store.getters.directoryCollection;
  }
};
</script>
