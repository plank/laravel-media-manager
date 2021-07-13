<template>
  <div class="modal">
    <a v-on:click.prevent="closeModal" href="#" class="modal-close">
      <svg width="22" height="22" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M21.598.402a1.362 1.362 0 00-1.934 0L11 9.066 2.336.402a1.362 1.362 0 00-1.934 0 1.362 1.362 0 000 1.933L9.067 11 .402 19.662a1.362 1.362 0 000 1.933c.264.263.618.405.962.405s.698-.132.962-.405l8.664-8.663 8.664 8.663c.263.263.618.405.962.405.354 0 .698-.132.961-.405a1.362 1.362 0 000-1.933L12.933 11l8.665-8.664a1.362 1.362 0 000-1.933z"
          fill-rule="nonzero"
          fill="#666"
        />
      </svg>
    </a>

    <div class="modal__container" v-bind:class="this.extraClassContainer">
      <div class="title text-center">
        <slot name="title"></slot>
      </div>
      <div class="content">
        <slot name="content"></slot>
      </div>
      <div class="buttons__container">
        <slot name="buttons"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "mmmodal",
  components: {},
  props: {
    extraClassContainer: {
      type: String,
      required: false,
    },
  },
  methods: {
    closeModal: function () {
      this.$store.dispatch("closeModal");
    },
    uploadSuccess: function () {
      this.$store.dispatch("closeModalCreate");
    },
  },
  computed: {
    getColor() {
      return this.$store.state.mainColor;
    },
    styleBtnDefault() {
      return {
        "--bg-color": this.$store.state.mainColor,
      };
    },
  },
};
</script>

<style lang="scss">
.vue-dropzone {
  .dz-preview {
    .dz-details {
      background: var(--bg-color) !important;
    }
  }
}
</style>
