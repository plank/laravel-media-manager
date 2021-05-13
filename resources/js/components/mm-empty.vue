<template>
  <div class="mm__empty">
    <iconempty></iconempty>
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
import iconempty from "./icons/icon-empty.vue";

export default {
  name: "mmempty",
  components: {
    iconempty,
  },
  methods: {
    openModal: function () {
      this.$store.dispatch("openModalAdd");
    },
  },
};
</script>
