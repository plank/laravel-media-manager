<template>
  <div class="mm__search">
    <div class="mm__search-container">
      <div class="mm__search-breadcrumb">
        <!-- <p v-html="getCurrentFolder"></p> -->
        <mmbreadcrumb></mmbreadcrumb>
      </div>
      <div class="mm__search-actions">
        <ul>
          <li v-if="showInformationsBtn">
            <a v-on:click="setCurrent($event, getSelected)" href="">
              <!-- Info -->
              <mmiconbase
                icon-name="add-folder"
                current-color="#8B8B8B"
                icon-color="#8B8B8B"
                width="26"
                height="23"
                viewBox="0 0 20 23"
                ><iconinfo></iconinfo
              ></mmiconbase>
            </a>
          </li>
          <li class="separator">
            <a v-on:click="openDeleteModal($event)" :title="$t('actions.delete')" href="">
              <!-- Delete Icon -->
              <mmiconbase
                icon-name="add-folder"
                current-color="#8B8B8B"
                icon-color="#8B8B8B"
                width="26"
                height="26"
                viewBox="0 0 26 26"
                ><icondelete></icondelete
              ></mmiconbase>
            </a>
          </li>
          <li>
            <a
              v-on:click="openModal($event)"
              :title="$t('actions.createDirectory')"
              href=""
            >
              <!-- Directory Icon -->
              <mmiconbase
                icon-name="add-folder"
                current-color="#8B8B8B"
                icon-color="#8B8B8B"
                width="26"
                height="26"
                viewBox="0 0 26 26"
                ><iconadddirectory></iconadddirectory
              ></mmiconbase>
            </a>
          </li>
          <li>
            <a
              :title="$t('actions.viewGrid')"
              v-on:click="viewState($event, false)"
              v-bind:class="{ active: this.$store.state.viewState === false }"
              href=""
            >
              <!-- Grid Icon -->
              <mmiconbase
                icon-name="icon-grid"
                current-color="000"
                icon-color="000"
                width="26"
                height="26"
                viewBox="0 0 26 26"
                ><icongrid></icongrid
              ></mmiconbase>
            </a>
          </li>
          <li>
            <a
              :title="$t('actions.viewList')"
              v-on:click="viewState($event, true)"
              v-bind:class="{ active: this.$store.state.viewState === true }"
              href=""
            >
              <!-- List Icon -->
              <mmiconbase
                icon-name="icon-list"
                current-color="000"
                icon-color="000"
                width="26"
                height="26"
                viewBox="0 0 26 26"
                ><iconlist></iconlist
              ></mmiconbase>
            </a>
          </li>
          <li>
            <a :title="$t('actions.search')" href="">
              <!-- Search Icon -->
              <mmiconbase
                icon-name="icon-list"
                current-color="000"
                icon-color="000"
                width="26"
                height="26"
                viewBox="0 0 26 26"
                ><iconsearch></iconsearch
              ></mmiconbase>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <!--
    <div class="mm__search-container">
      <input type="text" v-bind:placeholder="$t('search.input_placeholder')" />
      <button class="mm__search-send" type="send">Send</button>
    </div>
    -->
    <div>
      <select class="mm__search-select" name="" id="">
        <option value="">{{ $t("search.by_type") }}</option>
        <!-- Loop Here -->
        <option v-for="(item, index) in getDataTypes" v-bind:key="index" value="">
          {{ item.name }}
        </option>
      </select>

      <select class="mm__search-select" name="" id="">
        <option value="">{{ $t("search.by_date") }}</option>
        <option value="">{{ $t("actions.sort.oldest") }}</option>
        <option value="">{{ $t("actions.sort.newest") }}</option>
      </select>
    </div>
  </div>
</template>

<script>
import { EventBus } from "../event-bus.js";
import mmiconbase from "./mm-icon-base.vue";
import iconadddirectory from "./icons/icon-add-directory.vue";
import icongrid from "./icons/icon-grid.vue";
import iconlist from "./icons/icon-list.vue";
import iconsearch from "./icons/icon-search.vue";
import icondelete from "./icons/icon-delete.vue";
import iconinfo from "./icons/icon-info.vue";
import mmbreadcrumb from "./breadcrumb/mm-breadcrumb";

export default {
  name: "mmsearch",
  components: {
    mmiconbase,
    iconadddirectory,
    icongrid,
    iconlist,
    iconsearch,
    icondelete,
    iconinfo,
    mmbreadcrumb,
  },
  data() {
    return {
      showInformations: false,
    };
  },
  mounted() {},
  methods: {
    viewState: function (event, value) {
      event.preventDefault();
      this.$store.dispatch("viewState", value);
    },
    // Set Current State And Open Slidepanel
    setCurrent: function (event, id) {
      event.preventDefault();
      EventBus.$emit("open-slide-panel", id);
    },
    openModal: function ($event) {
      $event.preventDefault();
      this.$store.dispatch("openModalCreate");
    },
    openDeleteModal: function ($event) {
      $event.preventDefault();
      this.$store.dispatch("openModalDelete");
    },
  },
  computed: {
    getCurrentFolder() {
      return this.$store.state.currentDirectory;
    },
    // Get Main Color From Store
    getColor() {
      return this.$store.state.mainColor;
    },
    getDataTypes() {
      return this.$store.state.dataType;
    },
    getSelected() {
      return this.$store.state.selectedElem;
    },
    showInformationsBtn(getSelected) {
      if (this.getSelected.length !== 1) {
        return false;
      } else {
        return true;
      }
    },
  },
};
</script>
