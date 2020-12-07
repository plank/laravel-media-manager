<template>
  <div class="mm__card">
    <div>
      <img width="100%" src="https://via.placeholder.com/200" alt="" />
    </div>
    <div class="mm__card-infos">
      <h6>{{ item.filename }}</h6>
      <span class="type">{{ item.mime_type }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "mmcard",
  props: ["item"],
  data() {
    return {};
  },
  methods: {
  },
  mounted() {},
};
</script>
