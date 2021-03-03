<template>
  <div class="mm__results">
    <!-- For Each Loop -->
    <div class="mm__results-grid">
      <div v-for="item in getMedia" :key="item.id" class="mm__results-single">
        <mmcard :data-type="item.aggregate_type" :item="item"></mmcard>
      </div>
      <div class="mm__search-no-result" v-if="getMedia.length == 0 && this.$store.state.hideDirectory">
        <h3>{{ $t('search.no_result') }}</h3>
      </div>
    </div>
  </div>
</template>

<script>
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
