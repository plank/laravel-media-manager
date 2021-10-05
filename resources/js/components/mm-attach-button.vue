<template>
    <button
        v-on:click="attachImage(selectedElem, model, model_id, tag)"
        v-bind:style="{ background: getColor }"
        class="btn btn-rounded btn-attach"
    >
        <!-- Icon -->
        <span>attach!</span>
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
        attachImage: function(selectedElem, model, model_id, tag) {
            let imagesToAttach = [];
            selectedElem.forEach(element => {
                return imagesToAttach.push({
                    model: model,
                    model_id: model_id,
                    media: element.id,
                    tag: tag
                });
            });
            console.log(imagesToAttach, "imagesToAttach");

            if (imagesToAttach.length > 0) {
                axios
                    .post("/media-api/attach", {
                        data: imagesToAttach[0] // just sending the first index for now until the backend can handle multiple attachments 
                    })
                    .then(response => {
                        console.log(response, "response");
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
