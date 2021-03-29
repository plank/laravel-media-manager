<template>
  <div class="mm__empty">
    <mmiconbase
      icon-name="icon-empty"
      current-color="000"
      icon-color="000"
      width="209"
      height="244"
      viewBox="0 0 206 244"
      ><iconempty></iconempty
    ></mmiconbase>
  </div>
</template>

<script>
import mmiconbase from "./mm-icon-base.vue";
import iconempty from "./icons/icon-empty.vue";

export default {
  name: "mmempty",
  components: {
    mmiconbase,
    iconempty,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>
