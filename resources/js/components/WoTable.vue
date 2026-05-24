<template>
    <div>
        <vue-good-table
            :mode="remote ? 'remote' : null"
            style-class="vgt-table striped"
            max-height="500px"
            @on-page-change="pageChanged"
            @on-sort-change="sortChanged"
            @on-column-filter="columnFiltered"
            @on-per-page-change="perPageChanged"
            @on-selected-rows-change="selectionChanged"
            @on-search="searched"
            @on-row-click="onRowClicked"
            @on-row-dblclick="onRowDoubleClicked"
            @on-row-mouseenter="onRowMouseovered"
            :totalRows="totalRecords"
            :isLoading.sync="isLoading"
            :search-options="{
              enabled: true,
              skipDiacritics: true,
            }"
            :pagination-options="{
              enabled: true,
              perPage:perPage,
            }"
            :select-options="{
              enabled: enableCheckBox,
              selectOnCheckboxOnly: true,
            }"
            :group-options="{
                enabled: enableGroupOption,
                headerPosition: 'top',
                collapsable: enableCollapse,
            }"
            :columns="columns"
            :rows="rows"
        >
            <template slot="loadingContent">
                    <div class="spinner-grow" style="width: 1.5rem; height: 1.5rem;" role="status">
                    </div>
            </template>
            <template slot="table-header-row" slot-scope="props">
                <slot :name="props.column.field" :row="props.row">
                   {{props.formattedRow[props.column.field]}}
                </slot>
            </template>
            <template slot="table-row" slot-scope="props">
               <slot :name="props.column.field" :row="props.row">
                   {{props.formattedRow[props.column.field]}}
               </slot>
            </template>
        </vue-good-table>
    </div>
</template>

<script>
    export default {
        name: "WoTable",
        props: {
            columns: {type: Array, default: () => []},
            rows: {type: Array, default: () => []},
            totalRecords: {type: Number, default: 0},
            perPage: {type: Number, default: 10},
            loading: {type: Boolean, default: false},
            remote: {type: Boolean, default: false},
            enableCheckBox: {type: Boolean, default: true},
            enableGroupOption: {type: Boolean, default: false},
            enableCollapse: {type: Boolean, default: false},
        },
        data() {
            return {
                isLoading: false,
            };
        },
        watch: {
            loading(val) {
                this.isLoading = val;
            }
        },
        methods: {
            onRowClicked(params) {
                this.$emit('onRowClick', params)
            },
            onRowDoubleClicked(params) {
                this.$emit('onRowDoubleClick', params)
            },
            onRowMouseovered(params) {
                this.$emit('onRowMouseover', params)
            },
            selectionChanged(params) {
                this.$emit('onRowSelect', params.selectedRows);
            },
            pageChanged(params) {
                this.$emit('onPageChange', params.currentPage);
            },
            sortChanged(params) {
                this.$emit('onSortChange', {
                    sort: [
                        {
                            type: params[0].type,
                            columns: params[0].field
                        }
                    ]
                });
            },
            columnFiltered(params) {
                this.$emit('onColumnFilter', params.columnFilters);
            },
            perPageChanged(params) {
                this.$emit('onPerPageChanged', params);
            },
            searched(params){
                this.$emit('onSearch',params.searchTerm);
            }
        }
    };
</script>

<style>
    .vgt-wrap__footer {
        border: 0 solid transparent;
        background: transparent;
    }

    .vgt-table thead th {
        border-bottom: 0 solid transparent;
        background: transparent;
        /* background-color: #8B0000; */
    }

    .vgt-table th.line-numbers, .vgt-table th.vgt-checkbox-col {
        border-right: 0 solid transparent;
        background: transparent;
    }

    .vgt-wrap__footer .footer__row-count::after {
        display: none;
    }

    /*.vgt-global-search {*/
    /*    border: 0 solid transparent;*/
    /*    background: transparent;*/
    /*}*/
</style>
