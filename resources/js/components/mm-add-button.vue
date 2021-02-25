<template>
  <button
    v-on:click="openModal()"
    v-bind:style="{ background: getColor }"
    class="btn btn-rounded btn-add"
  >

    <!-- Icon -->
    <mmiconbase
        icon-name="add-folder"
        current-color="#C2C2C2"
        icon-color="#C2C2C2"
        width="34"
        height="30"
        ><iconaddmedia></iconaddmedia
    ></mmiconbase>

  </button>
</template>

<script>
import mmiconbase from './mm-icon-base.vue';
import iconaddmedia from './icons/icon-add-media.vue';

export default {
  name: 'mmaddbutton',
  components: {
    mmiconbase,
    iconaddmedia
  },
  data () {
    return {};
  },
  mounted () {},
  methods: {
    openModal: function () {
      this.$store.dispatch('OPEN_MODAL_ADD');
    }
  },
  computed: {
    getColor () {
      return this.$store.state.mainColor;
    }
  }
};
</script>
