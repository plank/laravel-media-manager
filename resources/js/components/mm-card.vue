<template>
  <div
    class="mm__card"
    v-bind:class="{ selected: setSelected }"
    v-on:click="pushSelected($event, item)"
  >
    <div>
      <div
        class="mm__card-placeholder mm__card-default-placeholder"
        v-if="
          item.aggregate_type === 'document' ||
          item.aggregate_type === 'pdf' ||
          item.aggregate_type === 'video'
        "
      >
        {{ item.extension }}
      </div>
      <img
        class="mm__card-placeholder"
        v-if="item.aggregate_type != 'audio'"
        width="100%"
        :src="item.conversion_urls.thumb"
        alt=""
      />
    </div>
    <div class="mm__card-infos">
      <h6>{{ item.filename }}</h6>
      <span class="type">{{ item.aggregate_type }}</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "mmcard",
  props: ["item"],
  data() {
    return {
      isSelected: false,
    };
  },
  methods: {
    // Push selected element to store
    pushSelected: function (event, value) {
      event.preventDefault();
      this.current = value.id;
      this.$store.dispatch("PUSH_SELECTED", value);
      this.isSelected = !this.isSelected;
    },
  },
  computed: {
    setSelected: function (item) {
      // Get all selected Elements
      // If contain -> True ELSE False
      const index = this.$store.state.selectedElem.findIndex(
        (elem) => elem.id === item.item.id
      );
      if (index === -1) {
        return false;
      } else {
        return true;
      }
    },
  },
  mounted() {},
};
</script>
