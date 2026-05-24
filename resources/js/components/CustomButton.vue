<template>
  <button
    :type="nativeType"
    class="btn"
    :class="buttonClass"
    @click="handleClick"
  >
    <slot></slot>
  </button>
</template>
<script>
export default {
  props: {
    buttonClass: {
      type: [Object, String],
      description: "Buttons",
      default: "btn btn-primary",
    },
    tag: {
      type: String,
      default: "button",
      description: "Html tag to use",
    },
    nativeType: {
      type: String,
      default: "button",
      description: "Native button type (e.g submit|button) ",
    },
  },
  methods: {
    handleClick(evt) {
      this.$emit("click", evt);
    },
  },
};
</script>
