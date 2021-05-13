<template>
  <button
    v-on:click="openModal()"
    v-bind:style="{ background: getColor }"
    class="btn btn-rounded btn-add"
  >
    <!-- Icon -->
    <iconaddmedia></iconaddmedia>
  </button>
</template>

<script>
import iconaddmedia from "./icons/icon-add-media.vue";

export default {
  name: "mmaddbutton",
  components: {
    iconaddmedia,
  },
  methods: {
    openModal: function () {
      this.$store.dispatch("openModalAdd");
    },
  },
  computed: {
    getColor() {
      return this.$store.state.mainColor;
    },
  },
};
</script>
