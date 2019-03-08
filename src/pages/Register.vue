<template>
    <div>
        <form class="mt-3" @submit.prevent="userRegister" autocomplete="off">
            <div class="form-group">
                <label for="email">{{t('Email')}}</label>
                <input type="email" class="form-control"
                       :class="{'is-invalid' : email.valid === false}" id="email" name="email"
                       :placeholder="t('Email')" v-model="email.value" @blur="checkEmail" @focus="$emit('alert', '', '')">
                <small class="form-text text-muted">{{t('Don\'t worry, we wont send you any spam')}}
                </small>
            </div>
            <div class="form-group">
                <label for="password">{{t('Password')}}</label>
                <input type="password" class="form-control" id="password" name="password"
                       :placeholder="t('Password')" v-model="password.value" @input="checkPassword"
                       @focus="in_password = !in_password" @blur="in_password = !in_password">
            </div>
            <div class="d-flex flex-column p-2 mb-3 bg-secondary text-white" role="alert" v-if="in_password">
                <small class="d-flex justify-content-end align-items-center">
                    {{t('Only english letters and numbers')}}
                    <i class="icon ion-md-checkmark icon-m ml-2 line-height-0"
                       :class="{'text-success' : (/^[A-Za-z0-9]+$/).test(password.value)}">
                    </i>
                </small>
                <small class="d-flex justify-content-end align-items-center">
                    {{t('At least 8 characters')}}
                    <i class="icon ion-md-checkmark ml-2 i-sm line-height-0"
                       :class="{'text-success' : password.value.length >= 8}"></i>
                </small>
                <small class="d-flex justify-content-end align-items-center">
                    {{t('Contain 1 capital letter')}}
                    <i class="icon ion-md-checkmark ml-2 i-sm line-height-0"
                       :class="{'text-success': (/[A-Z]/).test(password.value)}"></i>
                </small>
                <small class="d-flex justify-content-end align-items-center">
                    {{t('Contain 1 number')}}
                    <i class="icon ion-md-checkmark ml-2 i-sm line-height-0"
                       :class="{'text-success': (/[0-9]/).test(password.value)}"></i>
                </small>
            </div>
            <button type="submit" :disabled="!(email.valid && password.valid)" class="btn btn-primary w-100">
                {{t('Registration')}}
            </button>
        </form>
    </div>
</template>


<script>
    import validators from '../mixins/validators';
    import axios from '../axios';
    import router from '../router'

    export default {
        name: "register",
        mixins: [validators],
        data: function () {
            return {
                email: {
                    value: '',
                    valid: false
                },
                password: {
                    value: '',
                    valid: false
                },
                in_password: false,
            }
        },
        methods: {
            checkPassword() {
                if ((/^[A-Za-z0-9]+$/).test(this.password.value) && this.password.value.length >= 8 && (/[A-Z]/).test(this.password.value) && (/[0-9]/).test(this.password.value)) {
                    this.password.valid = true;
                } else {
                    this.password.valid = false;
                }
            },
            userRegister() {

                this.$emit('alert', '', '');

                let user = {
                    email: this.email.value,
                    password: this.password.value,
                };

                axios.post('user/register', user)
                    .then(res => {

                        this.$store.dispatch('register', res);

                        this.$emit('alert', 'success', this.t(res.data.message));

                        setTimeout(() => {
                            router.replace('/')
                        }, 2000)

                    }).catch(err => {

                    this.$emit('alert', 'error', this.t(err.response.data.message));

                });

            }
        }
    };


</script>







