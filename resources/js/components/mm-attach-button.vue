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
        attachImage: function(selectedElem, model, model_id) {
            // get the tag value and stard building the body of the req
            let tag = document.getElementById("tag").value;
            let imagesToAttach = {
                model: "App\\Models\\Article",
                model_id: model_id,
                tag: tag,
                media: []
            };
            // add the attached medid to the body of the request -- pictures to attach
            selectedElem.forEach(element => {
                return imagesToAttach.media.push(element.id);
            });

            console.log(imagesToAttach, "imagesToAttach");

            if (imagesToAttach.media.length > 0) {
                axios
                    .post("/media-api/attach", imagesToAttach)
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
