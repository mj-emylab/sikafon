<template>
    <div>
        <p v-if="status == 0" class="mb-2 text-xs">
            <i :style="`color:${level}`" :class="`${icon2}`"></i>
        </p>
        <p v-if="status == 1" class="mb-2 text-xs">
            <i :style="`color:${level1}`" :class="`${icon}`"></i>
        </p>
        <p v-if="status == 2" class="mb-2 text-xs">
            <i :style="`color:${level2}`" :class="`${icon}`"></i>
        </p>
        <p v-if="status == 3" class="mb-2 text-xs">
            <i :style="`color:${level3}`" :class="`${icon}`"></i>
        </p>
        
    </div>
</template>
<script>
    export default {
        props: {
            status: {
                type: [Number, String],
                default: 0
            },
            icon: {
                type: String,
                default: "fa fa-check"
            },
            icon2: {
                type: String,
                default: "fa fa-times"
            },
            level: {
                type: String,
                default: "red"
            },
            level1: {
                type: String,
                default: "blue"
            },
            level2: {
                type: String,
                default: "yellow"
            },
            level3: {
                type: String,
                default: "green"
            }
        },

    }
</script>
<style scoped>

</style>
