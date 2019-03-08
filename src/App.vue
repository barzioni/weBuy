<template>
    <div id="app">
        <alert :msg="msg"></alert>
        <navbar></navbar>
        <div id="app-router-view" class="container-fluid p-3">
            <router-view @alert="alert"></router-view>
        </div>
    </div>

</template>

<script>
    import alert from './components/alert';
    import navbar from './components/navbar';

    export default {
        name: "app",
        components: {alert, navbar},
        data: function () {
            return {
                msg: {
                    type: 'error',
                    body: [],
                },
            }
        },
        created() {
            this.$store.dispatch('tryAutoLogin');
        },
        methods: {

            alert(type, msg) {
                this.msg.type = type ? type : 'error';
                if (msg) {
                    this.msg.body.push(msg);
                } else {
                    this.msg.body = [];
                }

                setTimeout(() => {
                    this.msg.body = [];
                }, 4000)
            }
        }
    };

</script>


