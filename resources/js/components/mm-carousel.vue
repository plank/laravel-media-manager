<template>
  <transition name="fade">
    <div
      v-bind:class="{ minify: isMinify }"
      class="mm__carousel"
      v-if="totalSelected > 1 && !isMinimize && showCarousel"
    >
      <div class="mm__carousel-title">
        <div>
          <h2>{{ $t("carousel.title") }}</h2>
        </div>
        <div>
          <span class="mm__carousel-items-counter"
            >{{ totalSelected }} {{ $t("carousel.selected_items") }}</span
          >
        </div>
        <div>
          <a class="mm__carousel-minify-handler" v-on:click="minifyPanel($event)"
            ><i class="i-minimize"></i
          ></a>
        </div>
      </div>

      <div class="mm__carousel-reorder">
        {{ $t("carousel.drag_text") }}
      </div>

      <!-- Loop  -->
      <div class="mm__carousel-grid">
        <draggable id="draggable">
          <div v-for="(item, index) in this.$store.state.selectedElem" :key="index">
            <mmcarouselcard :index="index" :item="item"></mmcarouselcard>
          </div>
        </draggable>
      </div>

      <div class="mm__carousel-btn-container">
        <div>
          <a :style="styleBtnDefault" class="btn btn-default" href="">{{
            $t("carousel.btn_create")
          }}</a>
          <a
            v-on:click="cancelCarousel"
            :style="styleBtnDefault"
            class="btn btn-default-border"
            href=""
            >{{ $t("carousel.btn_cancel") }}</a
          >
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import mmcarouselcard from "./mm-carousel-card";
import draggable from "vuedraggable";

export default {
  name: "mmcarousel",
  components: {
    mmcarouselcard,
    draggable,
  },
  data() {
    return {
      showCarousel: false,
      isMinify: false,
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
    minifyPanel: function (event) {
      event.preventDefault();
      this.isMinify = !this.isMinify;
    },
    cancelCarousel: function (event) {
      event.preventDefault();
      // this.isMinimize = !this.isMinimize;
      // Reset selected elements to Null.
      this.$store.dispatch("resetSelected");
      // Remove all selected icons on view.
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
