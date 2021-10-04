<template>
    <button
        v-on:click="attachImage(selectedElem)"
        v-bind:style="{ background: getColor }"
        class="btn btn-rounded btn-attach"
    >
        <!-- Icon -->
        <span>attach!</span>
    </button>
</template>

<script>
import iconaddmedia from "./icons/icon-add-media.vue";

export default {
    name: "mmattachbutton",
    props: ["selectedElem"],
    components: {
        iconaddmedia
    },
    methods: {
        attachImage: function(selectedElem) {
            let imagesToAttach = [];
            selectedElem.forEach(element => {
                console.log(element.model)
                return imagesToAttach.push({
                    model: "",
                    model_id: "",
                    media: element.id,
                    tag: "",
                })
            });
            console.log(imagesToAttach, "imagesToAttach")
        }
    },
    computed: {
        getColor() {
            return this.$store.state.mainColor;
        }
    }
};
</script>
