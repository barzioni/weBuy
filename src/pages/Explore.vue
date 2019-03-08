<template>
    <div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4 mb-4" v-for="(product, index) in products" :key="product.id">
                <div class="card text-center rounded-0">
                    <div class="card-body position-relative">

                        <counter :timeleft="product.timeleft"></counter>

                        <img :src="baseUrl + 'images/' + product.image" class="img-fluid mb-3" alt="">
                        <h5 class="card-title">{{product.name}}</h5>

                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between position-relative">
                        <router-link :to="'product/' + product.id"
                                     class="btn-action border cursor-pointer position-absolute"><i
                                class="icon ion-md-add position-absolute x-y-align"></i></router-link>

                        <likes :id="product.id" :likes="product.likes" :index="index"
                               @updateProductLikes="onUpdateProductLikes"></likes>

                        <span class="badge badge-pill badge-primary"><span
                                class="font-bold">{{product.participants}}</span>/{{product.participants_max}}</span>

                    </div>
                </div>
            </div>

        </div>
    </div>
</template>


<script>
    import axios from '../axios';
    import likes from '../components/likes';
    import counter from '../components/counter';

    export default {
        name: "explore",
        components: {likes, counter},
        data() {
            return {
                products: [],
            }
        },
        mounted() {
            let that = this;
            axios.get('product/read')
                .then(function (response) {
                    that.products = response.data.data;
                })
                .catch(function (error) {

                });

        },
        methods: {
            onUpdateProductLikes(index, status) {
                if (status) {
                    this.products[index].likes--
                } else {
                    this.products[index].likes++
                }
            }
        },

    };

</script>







