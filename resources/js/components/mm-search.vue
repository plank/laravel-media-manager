<template>
  <div class="mm__search">
    <div class="mm__search-container">
      <div class="mm__search-term">
        <div class="mm__search-input">
          <input
            v-model="searchTerm"
            type="text"
            v-bind:placeholder="$t('search.input_placeholder')"
          />
          <div class="mm__search-launch">
            <a v-on:click.prevent="makeSearch" href="#">
              <iconsearch></iconsearch>
            </a>
          </div>
        </div>
        <div class="mm__search-close" v-if="this.$store.state.isSearch && this.isSearch">
          <a v-on:click.prevent="closeSearch" :title="$t('actions.search')" href="#">
            <iconclosesearch></iconclosesearch>
          </a>
        </div>
      </div>
      <div class="mm__search-breadcrumb">
        <mmbreadcrumb></mmbreadcrumb>
      </div>
      <div class="mm__search-actions">
        <ul>
          <li class="mm__search-icon" v-if="showInformationsBtn">
            <a v-on:click.prevent="setCurrent(getSelected[0])" href="">
              <iconinfo></iconinfo>
            </a>
          </li>

          <li
            v-if="
              this.$store.state.selectedDirectory ||
              showInformationsBtn ||
              this.$store.state.totalSelected > 1
            "
            class="mm__search-icon"
          >
            <a v-on:click.prevent="openDeleteModal" :title="$t('actions.delete')" href="">
              <icondelete></icondelete>
            </a>
          </li>
          <li class="mm__search-icon">
            <a
              v-on:click.prevent="openModal"
              :title="$t('actions.createDirectory')"
              href=""
            >
              <iconadddirectory></iconadddirectory>
            </a>
          </li>
          <li
            class="mm__search-icon"
            v-if="
              this.$store.state.selectedDirectory ||
              this.$store.state.selectedElem.length > 0
            "
          >
            <a v-on:click.prevent="openMoveModal" href="">
              <iconmove></iconmove>
            </a>
          </li>
          <li class="mm__search-icon" v-if="this.$store.state.totalSelected > 1">
            <a class="mm__search-deselect" v-on:click.prevent="deselectAll" href="#">{{
              $t("actions.deselectAll")
            }}</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="mm__search-filters">
      <select
        v-on:change.prevent="applyFilter"
        v-model="selectedFilterType"
        class="mm__search-select"
        name="selectedFilterType"
        id="selectedFilterType"
      >
        <option disabled value="">{{ $t("search.by_type") }}</option>
        <option value="all">All</option>
        <option
          v-for="(item, index) in this.$store.state.mediaTypeArray"
          v-bind:key="index"
        >
          {{ item.name | capitalize }} {{ item }}
        </option>
      </select>

      <select
        v-on:change.prevent="applyFilterDate"
        v-model="sortOrder"
        class="mm__search-select"
        name="sortOrder"
        id="sortOrder"
      >
        <option disabled value="">{{ $t("search.by_date") }}</option>
        <option value="asc">{{ $t("actions.sort.oldest") }}</option>
        <option value="desc">{{ $t("actions.sort.newest") }}</option>
      </select>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../event-bus.js";
import iconadddirectory from "./icons/icon-add-directory.vue";
import iconsearch from "./icons/icon-search.vue";
import icondelete from "./icons/icon-delete.vue";
import iconinfo from "./icons/icon-info.vue";
import iconmove from "./icons/icon-move.vue";
import iconclosesearch from "./icons/icon-close-search.vue";
import mmbreadcrumb from "./breadcrumb/mm-breadcrumb";

export default {
  name: "mmsearch",
  components: {
    iconadddirectory,
    iconsearch,
    icondelete,
    iconinfo,
    iconmove,
    iconclosesearch,
    mmbreadcrumb,
  },
  data() {
    return {
      showInformations: false,
      selectedFilterType: "",
      isSearch: false,
      searchTerm: null,
      sortOrder: "",
    };
  },
  mounted() {},
  methods: {
    // Set Current State And Open Slidepanel
    setCurrent: function (id) {
      EventBus.$emit("open-slide-panel", id);
    },
    openModal: function () {
      this.$store.dispatch("openModalCreate");
    },
    openDeleteModal: function () {
      this.$store.dispatch("openModalDelete");
    },
    openMoveModal: function () {
      this.$store.dispatch("openModalMove");
    },
    applyFilter: function () {
      const card = document.getElementsByClassName("mm__card");
      for (let i = 0; i < card.length; i++) {
        card.item(i).parentNode.classList.remove("hide");
        if (this.selectedFilterType !== "all") {
          if (
            card.item(i).dataset.type !== this.selectedFilterType &&
            card.item(i).dataset.type !== "folder"
          ) {
            card.item(i).parentNode.classList.add("hide");
          }
        } else {
          card.item(i).parentNode.classList.remove("hide");
        }
      }
    },
    applyFilterDate: function () {
      this.$store.dispatch("updateOrderBy", this.sortOrder);
    },
    deselectAll: function () {
      this.$store.dispatch("resetSelected");
    },
    closeSearch: function () {
      if (this.isSearch) {
        this.$store.state.hideDirectory = false;
        this.$store.dispatch("getDirectory", this.$store.state.currentDirectory);
      }
      this.isSearch = !this.isSearch;
    },
    makeSearch: function () {
      this.$store.dispatch("makeSearch", {
        vm: this,
        searchterm: this.searchTerm,
      });
      this.isSearch = true;
    },
  },
  computed: {
    getSelected() {
      return this.$store.state.selectedElem;
    },
    showInformationsBtn(getSelected) {
      return this.getSelected.length === 1;
    },
  },
  filters: {
    capitalize: function (value) {
      if (!value) return "";
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    },
  },
};
</script>
