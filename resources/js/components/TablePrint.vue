<template>
    <div>
        <vue-good-table
            :columns="columns"
            :rows="rows"
            :group-options="{
                enabled: enableGroupOption,
                headerPosition: 'top',
                collapsable: enableCollapse,
            }">
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
    name: "PrintTable",
    props: {
        columns: {type: Array, default: () => []},
        rows: {type: Array, default: () => []},
        enableGroupOption: {type: Boolean, default: true},
        enableCollapse: {type: Boolean, default: false},
    },
}
</script>
