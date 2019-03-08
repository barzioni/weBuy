<template>
    <div>
        <div class="product">
            <img src="" alt="">

        </div>
    </div>
</template>


<script>
    import axios from '../axios';

    export default {
        name: "product",
        data: function () {
            return {
                id: this.$route.params.id,
                product: []
            }
        },
        methods: {},
        mounted() {
            console.log(this.id);
            axios.get('product/read_one', {
                params: {
                    id: this.id
                }
            }).then(function (response) {
                console.log(response);
            }).catch(function (error) {
                console.log(error)
            });

        },
        beforeDestroy() {

        }
    };


</script>







