import axios from "axios";

export const actions = {
  closeModal(context) {
    let modals = [
      "CLOSE_MODAL_CREATE",
      "CLOSE_MODAL_DELETE",
      "CLOSE_MODAL_MOVE"
    ];

    modals.forEach(modal => {
      context.commit(modal, false);
    });
  },
  openModalCreate(context) {
    context.commit("OPEN_MODAL_CREATE", true);
  },
  closeModalCreate(context) {
    context.commit("CLOSE_MODAL_CREATE", false);
  },
  openModalDelete(context) {
    context.commit("OPEN_MODAL_DELETE", {
      modal_state: true
    });
  },
  closeModalDelete(context) {
    context.commit("CLOSE_MODAL_DELETE", false);
  },
  openModalAdd(context) {
    context.commit("OPEN_MODAL_ADD", true);
  },
  closeModalAdd(context) {
    context.commit("CLOSE_MODAL_ADD", false);
  },
  openModalMove(context) {
    context.commit("OPEN_MODAL_MOVE", true);
  },
  closeModalMove(context) {
    context.commit("CLOSE_MODAL_MOVE", false);
  },
  viewState(context, value) {
    context.commit("VIEW_STATE", value);
  },
  gridView(context, value) {
    context.commit("VIEW_STATE", value);
  },
  pushSelected(context, value) {
    const index = this.state.selectedElem.findIndex(
      item => item.id === value.id
    );

    if (index === -1) {
      this.state.selectedElem.push(value);
    } else {
      this.state.selectedElem.splice(index, 1);
    }
    this.state.totalSelected = this.state.selectedElem.length;
  },
  resetSelected(context, value) {
    context.commit("RESET_SELECTED", true);
    this.state.totalSelected = this.state.selectedElem.length;
  },

  getTranslatedDirectory({ commit }, value) {
    let route;
    this.state.isLoadingSidePanel = true;
    if (value) {
      this.state.currentDirectory = value;
      route = this.state.routeGetMedia + value;
    } else {
      this.state.currentDirectory = "";
      route = this.state.routeGetDirectory;
    }
    axios.get(route, {
        params: {
            locale: this.state.lang
        }
    }).then(response => {
      if (response.data) {
        this.state.selectedTranslation = response.data;
        this.state.isLoadingSidePanel = false;
      }
    });
  },
  getDirectory({ commit }, value) {
    let route;
    this.state.selectedElem = [];
    this.state.isLoading = true;
    if (value) {
      this.state.currentDirectory = value;
      route = this.state.routeGetDirectory + value;
    } else {
      this.state.currentDirectory = "";
      route = this.state.routeGetDirectory;
    }
    axios.get(route, {
        params: {
            locale: this.state.lang
        }
    }).then(response => {
      if (response.data.media) {
        commit("SET_MEDIA", response.data.media);
        commit("SET_MEDIATYPES", response.data.media);
        this.state.isLoading = false;
      }
      commit("SET_DIRECTORY", response.data.subdirectories);
    });
  },
  getMoveDirectory({ commit }, value) {
    let route;
    this.state.isLoading = true;
    if (value) {
      route = this.state.routeGetDirectory + value;
    } else {
      route = this.state.routeGetDirectory;
    }
    axios.get(route, {
        params: {
            locale: this.state.lang
        }
    }).then(response => {
      commit("SET_MOVE_DIRECTORY", response.data.subdirectories);
      this.state.isLoading = false;
    });
  },
  createDirectory({ commit }, value) {
    axios
      .post(this.state.routeCreateDirectory + "?path=" + value.name, {})
      .then(response => {
        commit("CLOSE_MODAL_CREATE", true);
        value.vm.$toast.open({
          type: "success",
          position: "bottom-left",
          message: value.name + " " + value.vm.$i18n.t("actions.created")
        });
        this.dispatch("getDirectory", this.state.currentDirectory);
      });
  },
  moveSelected({ commit }, value) {
    if (value.folder) {
      axios
        .post(this.state.routeMoveDirectory, {
          source: this.state.selectedDirectory.name,
          destination: value.destination.name
        })
        .then(response => {
          this.dispatch("closeModal");
          value.vm.$toast.open({
            type: "success",
            position: "bottom-left",
            message:
              this.state.selectedDirectory.name +
              " " +
              value.vm.$i18n.t("actions.moved")
          });
          value.vm.$store.dispatch(
            "getDirectory",
            value.vm.$store.state.currentDirectory
          );
        });
    }
    if (value.mediaCollection) {
      this.dispatch("moveSelectedMedia", {
        vm: value.vm,
        destination: value.destination.name,
        media: value.mediaCollection
      });
    }
  },
  deleteSelected({ commit }, value) {
    if (value.folder) {
      let route;
      if (value.folder) {
        this.state.currentDirectory = value.folder;
        route = this.state.routeDeleteDirectory + "?path=" + value.folder.name;
      } else {
        this.state.currentDirectory = "";
        route = this.state.routeDeleteDirectory;
      }
      axios.post(route, {}).then(response => {
        commit("CLOSE_MODAL");
        this.dispatch("getDirectory", response.data.parentFolder);
        value.vm.$toast.open({
          type: "success",
          position: "bottom-left",
          message: value.folder.name + " " + value.vm.$i18n.t("actions.deleted")
        });
      });
    }
    if (value.mediaCollection) {
      this.dispatch("deleteSelectedMedia", {
        vm: value.vm,
        media: value.mediaCollection
      });
    }
  },
  setSelectedDirectory(context, value) {
    context.commit("SET_SELECTED_DIRECTORY", value);
  },
  moveSelectedMedia({ commit, context }, value) {
    const media = [];
    const promises = [];
    for (let i = 0; i < value.media.length; i++) {
      promises.push(
        axios
          .post(this.state.routeUpdateMedia, {
            id: value.media[i].id,
            disk: value.media[i].disk,
            path: value.destination
          })
          .then(response => {
            commit("CLOSE_MODAL");
            this.dispatch("getDirectory", this.state.currentDirectory);
            value.vm.$toast.open({
              type: "success",
              position: "bottom-left",
              message:
                value.destination +
                value.media[i].filename +
                " " +
                value.vm.$i18n.t("actions.move")
            });
            media.push(response);
          })
      );
    }
    Promise.all(promises).then(() => console.log("move selected"));
  },
  deleteSelectedMedia({ commit, context }, value) {
    const media = [];
    const promises = [];
    for (let i = 0; i < value.media.length; i++) {
      promises.push(
        axios
          .post(this.state.routeDeleteMedia, {
            id: value.media[i].id
          })
          .then(response => {
            value.vm.$toast.open({
              type: "success",
              position: "bottom-left",
              message:
                value.media[i].filename +
                " " +
                value.vm.$i18n.t("actions.deleted")
            });
            media.push(response);
          })
      );
    }

    commit("CLOSE_MODAL");
    const self = this;

    setTimeout(
      () => self.dispatch("getDirectory", self.state.currentDirectory),
      500
    );

    Promise.all(promises).then(() => console.log("delete selected"));
  },
  makeSearch({ commit }, value) {
    axios
      .get(this.state.routeSearchMedia + "?q=" + value.searchterm, {})
      .then(response => {
        this.state.mediaCollection = response.data;
        this.state.hideDirectory = true;
      })
      .catch(error => {
        value.vm.$toast.open({
          type: "error",
          position: "bottom-left",
          message: error.toString()
        });
      });
  },
  updateOrderBy({ commit, state, dispatch }, data) {
    const directoryArray = Object.values(this.state.directoryCollection);
    const mediasArray = Object.values(this.state.mediaCollection);
    this.state.mediaCollection = mediasArray.sort(function(value1, value2) {
      if (data === "asc") {
        if (value1.timestamp > value2.timestamp) {
          return 1;
        } else {
          return -1;
        }
      }

      if (data === "desc") {
        if (value1.timestamp < value2.timestamp) {
          return 1;
        } else {
          return -1;
        }
      }
    });

    this.state.directoryCollection = directoryArray.sort(function(
      value1,
      value2
    ) {
      if (data === "desc") {
        if (value1.timestamp > value2.timestamp) {
          return 1;
        } else {
          return -1;
        }
      }

      if (data === "asc") {
        if (value1.timestamp < value2.timestamp) {
          return 1;
        } else {
          return -1;
        }
      }
    });
  },
  updateMedia(context, value) {
    axios
      .post(this.state.routeUpdateMedia, {
        locale: value.locale,
        disk: value.disk,
        title: value.title,
        id: value.id,
        alt: value.alt,
        credit: value.credit,
        caption: value.caption
      })
      .then(response => {
        value.vm.$toast.open({
          type: "success",
          position: "bottom-left",
          message: value.vm.$i18n.t("actions.uploaded")
        });
        // this.dispatch("getDirectory", this.state.currentDirectory);
      });
  },
  setLang(context, value) {
    context.commit("SET_LANG", value);
  },
};
