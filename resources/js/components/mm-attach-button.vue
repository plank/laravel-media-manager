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
                media: [],
                sync: false
            };
            // add the attached medid to the body of the request -- pictures to attach
            selectedElem.forEach(element => {
                return imagesToAttach.media.push(element.id);
            });

            if (imagesToAttach.media.length > 0) {
                this.$store.dispatch("attatchMedia", imagesToAttach)
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
