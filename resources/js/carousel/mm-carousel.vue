<template>
  <transition name="fade">
    <div class="mm__carousel" v-if="totalSelected > 1 && !isMinimize">
      <h2>{{ $t("carousel.title") }}</h2>

      <!-- <a v-on:click="hidePanel($event)">close</a> -->

      <!-- Loop  -->
      <div class="mm__carousel-grid">
        <div v-for="(item, index) in this.$store.state.selectedElem" :key="index">
          <mmcarouselcard :index="index" :item="item"></mmcarouselcard>
        </div>
      </div>

      <div class="mm__carousel-reorder">Drag photo to reorder</div>

      <div class="mm__carousel-btn-container">
        <div>
          <a :style="styleBtnDefault" class="btn btn-default" href="">{{
            $t("carousel.btn_create")
          }}</a>
          <a :style="styleBtnDefault" class="btn btn-default-border" href="">{{
            $t("carousel.btn_cancel")
          }}</a>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import mmcarouselcard from "./mm-carousel-card";
export default {
  name: "mmcarousel",
  components: {
    mmcarouselcard,
  },
  data() {
    return {
      isMinimize: false,
    };
  },
  methods: {
    updateHoverState(isHover) {
      this.hoverState = isHover;
    },
    hidePanel: function (event) {
      event.preventDefault();
      this.isMinimize = !this.isMinimize;
    },
  },
  mounted() {},
  computed: {
    styleBtnDefault() {
      return {
        "--bg-color": this.$store.state.mainColor,
      };
    },
    totalSelected() {
      return this.$store.state.totalSelected;
    },
  },
};
</script>

<style lang="sass">
.btn-default
    background: var(--bg-color)
    border-color: var(--bg-color)
    &:hover
        background: white
        border-color: var(--bg-color)
        color: var(--bg-color)
        transition: all 0.2s ease-in-out

.btn-default-border
    border: var(--bg-color)
    color: var(--bg-color)
    &:hover
        background: var(--bg-color)
        color: white
        transition: all 0.2s ease-in-out
</style>
