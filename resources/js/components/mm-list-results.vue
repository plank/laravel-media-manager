<template>
  <div class="mm__results">
    <table class="mm-table">
      <thead>
        <tr>
          <th class="mm-table__input" width="40"></th>
          <th width="75">Preview</th>
          <th>Name</th>
          <th>Type</th>
          <th>Upload Date</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in mediaCollection" v-bind:key="index">
          <td class="mm-table__input">
            <input type="checkbox" :id="item.id" :data-index="item.id" v-on:click="pushSelected($event, item)" :checked="isSelected" />
          </td>
          <td>
            <img src="https://via.placeholder.com/75" alt="" />
          </td>
          <td>
            <strong>{{ item.filename }}</strong>
          </td>
          <td>{{ item.mime_type }}</td>
          <td>{{ item.created_at }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

export default {
  name: 'mmlistresults',
  components: {},
  data () {
    return {
      checked: false,
      current: null,
      isSelected: false,
      selectedItem: [],
      mediaCollection: this.$store.state.mediaCollection
    };
  },
  methods: {
    // Push selected element to store
    pushSelected: function (event, value) {
      this.$store.dispatch('PUSH_SELECTED', value);
    }
  },
  watch: {
    '$store.state.selectedElem': function () {
      const index = this.$store.state.selectedElem.length;
      if (index === 0) {
        document.querySelectorAll('input').forEach(checkbox => {
          checkbox.checked = false;
        });
      }
    }
  },
  mounted () {
    const index = this.$store.state.selectedElem;
    for (const key in index) {
      document.getElementById(index[key].id).checked = true;
    }
  }
};
</script>
