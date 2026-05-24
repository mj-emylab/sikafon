<template>
    <div class="d-flex">
        <button @click="upload" type="button" :class="`btn btn-rounded btn-block btn-${variant} ${size}`">
            <span :class="`btn-icon-left text-${variant}`">
                <i :class="`fa ${icon} color-${variant}`"></i>
            </span>
            <span class="text-white">{{label}}</span>
            <span v-if="totalFiles.length>0" :class="`badge badge-xs light badge-${variant}`">
             <i :class="`fa fa-check-circle`"></i>
                {{totalFiles.length}} file(s)
            </span>
        </button>
        <div style="margin-left: 10px; align-self: center" v-if="totalFiles.length>0">
            <button @click="clearFiles" type="button"
                    class="btn btn-outline-light btn-xs"
                    style="padding: 5px !important;">
                <i :class="`fa fa-window-close text-danger`"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'WoFileUploader',
        props: {
            icon: {
                type: String,
                default: 'fa-upload',
            },
            label: {
                type: String,
                default: 'Upload',
            },
            multiple: {
                type: Boolean,
                default: false,
            },
            iconOnly: {
                type: Boolean,
                default: false,
            },
            loading: {
                type: Boolean,
                default: false,
            },
            variant: {
                type: String,
                default: 'primary',
            },
            size: {
                type: String,
                default: 'col-12',
            },
            accept: {
                type: String,
                default: 'image/jpeg, image/png, image/jpg',
            },
        },
        data() {
            return {
                totalFiles: []
            }
        },
        methods: {
            
            clearFiles() {
                this.totalFiles = [];
                this.$emit('onUpload', this.multiple ? [] : null)
            },
            upload() {
                const el = document.createElement('input')
                el.type = 'file'
                if (this.multiple) {
                    el.multiple = true
                }
                el.accept = this.accept
                el.onchange = event => {
                    const {files} = event.target
                    if (this.multiple) {
                        this.totalFiles = [...this.totalFiles, ...files];
                        this.$emit('onUpload', this.totalFiles)
                    } else {
                        this.totalFiles = files;
                        this.$emit('onUpload', this.totalFiles[0])
                    }
                    
                }
                el.click()
            },
        }
    }
</script>
<style scoped>

</style>
