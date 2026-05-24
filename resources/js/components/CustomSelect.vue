<template>
  <div class="form-group">
    <label
      ><strong>{{ title }}</strong></label
    >
    <v-select
      :options="options"
      :label="label"
      :value="value"
      @input="(val)=>$emit('input', val)"
      :placeholder="placeholderText"
      :reduce="options => options"
    >
    </v-select>
  </div>
</template>

<script>
export default {
  name: "WoSelect",
  props: {
    options: {
      type: Array,
      required: true,
    },
    value: {
      type: [String, Object],
      default: ""
    },
    label: {
      type: String,
      default: "label",
    },
    title: {
      type: String,
      default: "Select",
    },
    placeholderText: {
       type: String,
       default: "Select Item"
    }
  },
};
</script>
