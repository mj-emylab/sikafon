<template>
  <div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    :aria-hidden="true"
    :class="modalClassName"
  >
    <div class="modal-dialog" :class="modalClasses ? modalClasses : 'modal-lg'">
      <div class="modal-content">

        <div class="modal-header alert-danger" v-if="showHeader" :class="headerClasses">
          <slot name="header"></slot>
          <slot name="close-button">
            <button
              type="button"
              v-if="showClose"
              class="close"
              data-dismiss="modal"
              :aria-hidden="true"
            >
              <span>&times;</span>
            </button>
          </slot>
        </div>

        <div class="modal-body" :class="bodyClasses">
           <slot></slot>
        </div>

        <div class="modal-footer alert-danger" v-if="showFooter">
            <slot name="footer"></slot>
        </div>

      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "modal",
  props: {
    showHeader: {
      type: Boolean,
      default: true,
      description: "Hide or Show Modal header",
    },
    showClose: {
      type: Boolean,
      default: true,
    },
    modalClasses: {
      type: [Object, String],
      description: "Modal Classes",
    },
    headerClasses: {
      type: [Object, String],
      description: "Any additinal classes to header",
    },
    bodyClasses: {
      type: [Object, String],
      description: "Modal Body css classes",
    },
    modalClassName: {
      type: [Object, String],
      description: "Modal Class Name",
    },
    footerClasses: {
      type: [Object, String],
      description: "Modal Footer css classes",
    },
    showFooter: {
       type: Boolean,
       default: true,
    }
  },
};
</script>
<style>
  .footerCustomClass {
      margin-top: 10px;
      border-top: 1px solid rgb(216, 210, 210);
      background-color: white;
      padding-top: 15px;
  }
</style>
