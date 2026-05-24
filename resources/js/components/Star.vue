<template>
    <div>
        <p v-if="count(item) == 0" class="mb-2 text-xs">
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
        </p>
        <p v-if="count(item) == 1" class="mb-2 text-xs">
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
        </p>
        <p v-if="count(item) == 2" class="mb-2 text-xs">
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
        </p>
        <p v-if="count(item) == 3" class="mb-2 text-xs">
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
        </p>
        <p v-if="count(item) == 4" class="mb-2 text-xs">
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorDown}`"></i>
        </p>
        <p v-if="count(item) > 4" class="mb-2 text-xs">
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
            <i :class="`${icon} ${colorUp}`"></i>
        </p>
    </div>
</template>
<script>
    export default {
        props: {
            item: {type: Array, default: () => []},
            colorUp: {
                type: String,
                default: "text-warning"
            },
            colorDown: {
                type: String,
                default: "text-gray-300"
            },
            icon: {
                type: String,
                default: "fa fa-star"
            }
        },
        methods: {
            count(items) {
                // console.log(items)
                let counter = 0;

                if(items.length >0 || items != null) {

                    items.forEach(item => {
                        if(item.action > 3) {
                            counter++
                        }
                    });
                }

                return counter;
            }
        },

    }
</script>
<style scoped>

</style>
