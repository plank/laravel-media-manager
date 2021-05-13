<template>
  <div class="mm__carousel-card">
    <div>
      <span v-on:click="removeFromSelected(item)">x</span>
      <div class="thumb" :style="backgroundImage(item)"></div>
    </div>
  </div>
</template>

<script>
export default {
  name: "mmcarouselcard",
  components: {},
  props: ["item", "index"],
  methods: {
    removeFromSelected: function (value) {
      this.$store.dispatch("pushSelected", value);
    },
  },
  computed: {
    backgroundImage: () => (item) => {
      return 'background-image: url("' + item.conversion_urls.thumb + '")';
    },
  },
};
</script>
