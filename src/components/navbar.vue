<template>
    <div>
        <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white border-top    ">
            <ul class="navbar-nav w-100 d-flex justify-content-around flex-row flex-md-column">

                <li class="nav-item my-md-3" v-if="!isAuth">
                    <router-link to="/register" class="nav-link text-center text-secondary">
                        <i class="icon ion-md-person-add i-md"></i>
                        <br>
                        <small>{{t('Registration')}}</small>
                    </router-link>
                </li>

                <li class="nav-item my-md-3">
                    <router-link to="/" class="nav-link text-center text-secondary">
                        <i class="icon ion-md-home i-md"></i>
                        <br>
                        <small>{{t('Home')}}</small>
                    </router-link>
                </li>

                <li class="nav-item my-md-3" v-if="!isAuth">
                    <router-link to="/login" class="nav-link text-center text-secondary">
                        <i class="icon ion-md-log-in i-md"></i>
                        <br>
                        <small>{{t('Login')}}</small>
                    </router-link>
                </li>

                <li class="nav-item my-md-3" v-if="isAuth">
                    <router-link to="/create" class="nav-link text-center text-secondary">
                        <i class="icon ion-md-add-circle-outline i-md"></i>
                        <br>
                        <small>{{t('Create')}}</small>
                    </router-link>
                </li>

                <li class="nav-item my-md-3" v-if="isAuth">
                    <router-link to="/account" class="nav-link text-center text-secondary">
                        <i class="icon ion-md-cog i-md"></i>
                        <br>
                        <small>{{t('Account')}}</small>
                    </router-link>
                </li>

                <li class="nav-item my-md-3" v-if="isAuth">
                    <a href="" class="nav-link text-center text-secondary" @click="logout">
                        <i class="icon ion-md-log-out i-md"></i>
                        <br>
                        <small>{{t('Logout')}}</small>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</template>

<script>

    export default {
        name: "navbar",

        computed: {
            isAuth() {
                return this.$store.getters.isAuth;
            }
        },
        methods: {
            logout() {
                this.$store.dispatch('logout');
            },

        }
    }
</script>