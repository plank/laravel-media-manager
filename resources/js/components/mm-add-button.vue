<template>
  <button v-on:click="openModal()" v-bind:style="{ background: getColor }" class="btn btn-rounded btn-add">
    <i class="i-add"></i>
  </button>
</template>

<script>
export default {
  name: 'mmaddbutton',
  data () {
    return {};
  },
  mounted () {},
  methods: {
    openModal: function () {
      this.$store.dispatch('openModalAdd');
    }
  },
  computed: {
    getColor () {
      return this.$store.state.mainColor;
    }
  }
};
</script>
