<template>
  <div class="mm__carousel-card">
    <div>
      <span v-on:click="removeFromSelected(item)">x</span>
      <img width="100%" :src="item.url" alt="" />
    </div>
  </div>
</template>

<script>
export default {
  name: "mmcarouselcard",
  components: {},
  props: ["item", "index"],
  data() {
    return {};
  },
  methods: {
    removeFromSelected: function (value) {
      this.$store.dispatch("pushSelected", value);
    },
  },
  mounted() {},
  computed: {},
};
</script>
