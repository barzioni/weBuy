<template>
    <div>
        <div class="form-group">
            <label>{{label}}</label>
            <multiselect v-model="value" :options="options" :multiple="true" :max="5" @input="$emit('onTagsChange', value)" placeholder=""></multiselect>
        </div>
    </div>
</template>

<script>
    //https://vue-multiselect.js.org/
    import Multiselect from 'vue-multiselect'
    import tags from '../localData/tags';

    export default {
        components: {Multiselect},
        props:['label'],
        mounted(){
            for(let tag in tags[this.lang]){
                this.options.push(tags[this.lang][tag]);
            }
        },
        data() {
            return {
                value: null,
                options: []
            }
        }
    }
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
    .multiselect__tags {
        border-radius: 0px;
        /*display: block;*/
        /*width: 100%;*/
        /*height: calc(2.25rem + 2px);*/
        /*padding: .375rem .75rem;*/
        /*font-size: 1rem;*/
        /*line-height: 1.5;*/
        /*color: #495057;*/
        /*background-color: #fff;*/
        /*background-clip: padding-box;*/
        /*border: 1px solid #ced4da;*/
        /*transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;*/
    }
</style>