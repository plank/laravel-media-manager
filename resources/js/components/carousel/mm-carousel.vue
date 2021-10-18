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
          <span class="mm__carousel-items-counter">
            {{ totalSelected }} {{ $t("carousel.selected_items") }}
          </span>
        </div>
        <div>
          <a class="mm__carousel-minify-handler" v-on:click.prevent="minifyPanel">
            <i class="i-minimize"></i>
          </a>
        </div>
      </div>

      <div class="mm__carousel-reorder">
        {{ $t("carousel.drag_text") }}
      </div>

      <div class="mm__carousel-grid">
        <draggable :list="this.$store.state.selectedElem" id="draggable">
          <div v-for="(item, index) in this.$store.state.selectedElem" :key="index">
            <mmcarouselcard :index="index" :item="item"></mmcarouselcard>
          </div>
        </draggable>
      </div>

      <div class="mm__carousel-btn-container">
        <div>
          <a
            @click.prevent="copyCarouselDOM()"
            :style="styleBtnDefault"
            class="btn btn-default"
            href=""
          >
            {{ $t("carousel.btn_create") }}
          </a>
          <a
            v-on:click.prevent="cancelCarousel"
            :style="styleBtnDefault"
            class="btn btn-default-border"
            href=""
          >
            {{ $t("carousel.btn_cancel") }}
          </a>
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
      showCarousel: true,
      isMinify: true,
      isMinimize: false,
    };
  },
  methods: {
    minifyPanel: function () {
      this.isMinify = !this.isMinify;
    },
    cancelCarousel: function () {
      this.$store.dispatch("resetSelected");
    },
    copyToClipboard: function (text) {
      const dummyTextarea = document.createElement("textarea");
      document.body.appendChild(dummyTextarea);
      dummyTextarea.value = text;
      dummyTextarea.select();
      document.execCommand("copy");
      document.body.removeChild(dummyTextarea);
    },
    copyCarouselDOM: function () {
      const imagesArray = [];
      this.$store.state.selectedElem.forEach(function (element) {
        imagesArray.push(
          '<div><img src="' + element.url + '" alt="' + element.alt + '"></div>'
        );
      });

      // Create General BxSlider Structure
      const customDOM =
        '<div class="slider">' +
        '<div class="bxslider">' +
        imagesArray.join("") +
        '<div class="bxslider-controls"><a href="#" class="bx-prev">Précédent</a><a href="#" class="bx-next">Suivant</a></div>' +
        "</div>";

      this.copyToClipboard(customDOM);

      this.$toast.open({
        type: "success",
        position: "bottom-left",
        message: this.$i18n.t("actions.copyToClipboard"),
      });
    },
  },
  computed: {
    styleBtnDefault() {
      return {
        "--bg-color": this.$store.state.mainColor,
      };
    },
    totalSelected() {
      if (this.$store.state.totalSelected > 1 && this.isMinify && this.showCarousel) {
        document.body.classList.add("mm__carousel-open");
      } else {
        document.body.classList.remove("mm__carousel-open");
      }
      return this.$store.state.totalSelected;
    },
  },
};
</script>

<style lang="scss">
.btn-default {
	background: var(--bg-color);
	border-color: var(--bg-color);

	&:hover {
		background: #fff;
		border-color: var(--bg-color);
		color: var(--bg-color);
		transition: all 0.2s ease-in-out;
	}
}

.btn-default-border {
	border: var(--bg-color);
	color: var(--bg-color);

	&:hover {
		background: var(--bg-color);
		color: #fff;
		transition: all 0.2s ease-in-out;
	}
}
</style>
