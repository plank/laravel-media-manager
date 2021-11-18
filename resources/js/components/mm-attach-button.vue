<template>
    <button
        v-on:click="attachImage(selectedElem, model, model_id, tag)"
        v-bind:style="{ background: getColor }"
        class="btn btn-rounded btn-attach"
    >
        <!-- Icon -->
        <span>Attach</span>
    </button>
</template>

<script>
import iconaddmedia from "./icons/icon-add-media.vue";
import axios from "axios"; // We import axios for ajax requests

export default {
    name: "mmattachbutton",
    props: ["selectedElem", "tag", "model", "model_id"],
    components: {
        iconaddmedia
    },
    methods: {
        capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        attachImage: function(selectedElem, model, model_id, tag) {
            let imagesToAttach = {
                model: `App\\Models\\${this.capitalize(model)}`,
                model_id: model_id,
                tag: tag,
                media: []
            };
            // add the attached medid to the body of the request -- pictures to attach
            selectedElem.forEach(element => {
                return imagesToAttach.media.push(element.id);
            });


            if (imagesToAttach.media.length > 0) {
                axios
                    .post("/media-api/attach", imagesToAttach)
                    .then(response => {
                        location.reload();
                    })
                    .catch(e => {
                        console.log(e, "error");
                    });
            }
        }
    },
    computed: {
        getColor() {
            return this.$store.state.mainColor;
        }
    }
};
</script>
