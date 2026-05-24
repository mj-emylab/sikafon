<template>
  <div class="form-group">
    <label class="mb-1"
      ><strong>{{ label }}</strong>
      <span v-if="isInvalid" class="text-danger">*</span></label
    >
    <input
      :type="type"
      class="form-control"
      :class="{ 'is-invalid': isInvalid }"
      :value="value"
      v-on:input="$emit('input', $event.target.value)"
      :placeholder="placeholder"
      :disabled="disabled"
      :id="id"
    />
    <div class="error" v-if="validateParams.$error">

        <div v-if="'required' in validateParams">
             <div v-if="!validateParams.required"> {{ label }}  is required </div>
        </div>

        <div v-if="'minLength' in validateParams">
             <div v-if="!validateParams.minLength">
                {{ label }}  must have at least {{ validateParams.$params.minLength ? validateParams.$params.minLength.min : 0 }} letters.
            </div>
        </div>

        <div v-if="'email' in validateParams">
            <div v-if="validateParams.email ? !validateParams.email : true">Accepts valid email addresses</div>
        </div>

    </div>

  </div>
</template>
<script>
export default {
  props: {
    label: {
      type: String,
      default: "",
    },
    type: {
      type: String,
      required: true,
    },
    placeholder: {
      type: String,
      default: "",
    },
    value: {
      default: "",
    },
    isInvalid: {
      type: Boolean,
      default: false,
    },
    validateParams: {
        type: [String, Object],
        default: ""
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    id: {
       type: String,
       default: "",
    }
  },
};
</script>
<style scoped>
.error {
    color: #F67F6C;
}
</style>
