<template>
  <div
    class="mm__card"
    v-bind:class="{ selected: setSelected }"
    v-on:click="pushSelected($event, item)"
  >
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
  name: 'mmcard',
  props: ['item'],
  data () {
    return { isSelected: false };
  },
  methods: {
    // Push selected element to store
    pushSelected: function (event, value) {
      event.preventDefault();
      this.current = value.id;
      this.$store.dispatch('pushSelected', value);
      this.isSelected = !this.isSelected;
    }
  },
  computed: {
    setSelected: function (item) {
      // Get all selected Elements
      // If contain -> True ELSE False
      const index = this.$store.state.selectedElem.findIndex(elem => elem.id === item.item.id);
      if (index === -1) {
        return false;
      } else {
        return true;
      }
    }
  },
  mounted () {}
};
</script>
