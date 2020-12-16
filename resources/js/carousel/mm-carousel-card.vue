<template>
  <div class="mm__carousel-card">
    <div>
      <span>{{ index + 1 }}</span>
      <img width="100%" src="https://source.unsplash.com/1600x900/?music" alt="" />
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
  methods: {},
  mounted() {},
  computed: {},
};
</script>
