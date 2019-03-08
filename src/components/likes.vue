<template>
    <div>
        <div class="likes text-muted">
            <i class="icons cursor-pointer" :class="[userLikes(id) ? 'ion-ios-heart' : 'ion-ios-heart-empty']"
               @click="like"></i>
            <span class="ml-1">{{likes}}</span>
        </div>
    </div>
</template>

<script>
    import axios from '../axios';

    export default {
        name: "likes",
        props: ['id', 'likes', 'index'],
        methods: {
            userLikes(id) {
                let products = this.$store.getters.userLikes;
                if (products) {
                    return products.includes(id);
                } else {
                    return false;
                }
            },
            like() {
                if (this.$store.getters.isAuth) {
                    let status = this.userLikes(this.id);

                    let data = {
                        jwt: this.$store.getters.jwt,
                        productId: this.id,
                        userId: this.$store.getters.userId,
                        like: this.userLikes(this.id, status)
                    };

                    let that = this;
                    axios.post('product/like', data)
                        .then(function (res) {
                            console.log(res);
                            that.$store.dispatch('like', data);
                        })
                        .catch(function (err) {
                            console.log(err);
                        });

                    this.$emit("updateProductLikes", this.index, status);
                }

            }
        }
    }
</script>