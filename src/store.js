import Vue from 'vue';
import Vuex from 'vuex';
import router from './router'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {
            token: null,
            id: null,
            email: null,
            likes: [],
            lang: null,
        },
    },
    mutations: {
        authUser(state, userData) {
            state.user.token = userData.token;
            state.user.id = userData.id;
            state.user.email = userData.email;
            state.user.likes = userData.likes ? userData.likes : [];
        },

        clearAuthData(state) {
            state.user.token = null;
            state.user.id = null;
        },

        setLikes(state, productId) {
            let obj = state.user.likes;
            if (obj.includes(productId)) {
                let index = obj.indexOf(productId);
                obj.splice(index, 1);
            } else {
                obj.push(productId)
            }
            localStorage.setItem('likes', JSON.stringify(obj));
        }
    },
    actions: {
        setLogoutTimer({commit}, expTime) {
            setTimeout(() => {
                commit('clearAuthData')
            }, expTime * 1000)
        },

        register({commit, dispatch}, authData) {

            commit('authUser', {
                token: authData.data.data.jwt,
                id: authData.data.data.userId
            });

            dispatch('setLogoutTimer', authData.data.data.exp);

            const now = new Date();
            const expDate = new Date(now.getTime() + authData.data.data.exp * 1000);
            localStorage.setItem('token', authData.data.data.jwt);
            localStorage.setItem('id', authData.data.data.userId);
            localStorage.setItem('expIn', expDate);

        },

        login({commit, dispatch}, authData) {

            commit('authUser', {
                token: authData.data.data.jwt,
                id: authData.data.data.userData.id,
                email: authData.data.data.userData.email,
                likes: authData.data.data.userData.likes
            });
            dispatch('setLogoutTimer', authData.data.data.exp);
            const now = new Date();
            const expDate = new Date(now.getTime() + authData.data.exp * 1000);
            localStorage.setItem('token', authData.data.data.jwt);
            localStorage.setItem('id', authData.data.data.userData.id);
            localStorage.setItem('likes', JSON.stringify(authData.data.data.userData.likes));
            localStorage.setItem('expIn', expDate);

        },

        logout({commit}) {
            commit('clearAuthData');
            localStorage.removeItem('token');
            localStorage.removeItem('id');
            localStorage.removeItem('expIn');
            localStorage.removeItem('likes');
            router.replace('/login');
        },

        tryAutoLogin({commit}) {
            const token = localStorage.getItem('token');
            if (!token) {
                return;
            }
            const expDate = localStorage.getItem('expIn');
            const now = new Date();
            if (now >= expDate) {
                return;
            }
            const userId = localStorage.getItem('id');
            const userLikes = JSON.parse(localStorage.getItem('likes'));
            commit('authUser', {
                token: token,
                id: userId,
                likes: userLikes ? userLikes : []
            })
        },

        like({commit, dispatch}, data) {
            commit('setLikes', data.productId);
        }
    },
    getters: {
        isAuth(state) {
            return state.user.token != null;
        },
        jwt(state) {
            return state.user.token;
        },
        userId(state) {
            return state.user.id;
        },
        lang(state) {
            return state.user.lang;
        },
        userLikes(state) {
            return state.user.likes;
        }
    }
})