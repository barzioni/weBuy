<template>
    <div>
        <form class="mt-3" @submit.prevent="userLogin" autocomplete="off">
            <div class="form-group">
                <label for="email">{{t('Email')}}</label>
                <input type="email" class="form-control" id="email" name="email"
                       :placeholder="t('Email')"
                       v-model="email.value" @blur="checkEmail" @focus="$emit('alert', '', '')">
            </div>
            <div class="form-group">
                <label for="password">{{t('Password')}}</label>
                <input type="password" class="form-control" id="password" name="password"
                       :placeholder="t('Password')" v-model="password">
            </div>
            <button type="submit" :disabled="!(email.valid && password.length >= 8)"
                    class="btn btn-primary w-100">
                {{t('Login')}}
            </button>
        </form>
    </div>
</template>


<script>
    import validators from '../mixins/validators';
    import axios from '../axios';
    import router from '../router'

    export default {
        name: "Login",
        mixins: [validators],

        data: function () {
            return {
                email: {
                    value: '',
                    valid: false
                },
                password: {
                    value: '',
                },
                in_password: false,

            }
        },
        methods: {
            userLogin() {
                this.$emit('alert', '', '');
                let user = {
                    email: this.email.value,
                    password: this.password,
                };

                axios.post('user/login', user)
                    .then(res => {

                        this.$store.dispatch('login', res);

                        this.$emit('alert', 'success', this.t(res.data.message));

                        setTimeout(() => {
                            router.replace('/')
                        }, 2000);

                    }).catch(err => {

                    this.$emit('alert', 'error', this.t(err.response.data.message));

                });

            }
        },

    };


</script>







