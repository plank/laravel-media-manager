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
    <h2>{{ $t("actions.empty_folder") }}</h2>
    <h3>
      {{ $t("actions.upload_text_click") }}
      <a href="#" class="link" @click.prevent="openModal()">{{
        $t("actions.upload_text_here")
      }}</a>
      {{ $t("actions.upload_text_up") }}
    </h3>
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
  methods: {
    openModal: function () {
      this.$store.dispatch("OPEN_MODAL_ADD");
    },
  },
};
</script>
