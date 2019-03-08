export default {
    methods: {
        checkEmail() {
            if ((/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/).test(this.email.value)) {
                this.$emit('alert', '', '');
                this.email.valid = true;
            } else {
                this.$emit('alert', 'error', this.t('Email is not valid'));
                this.email.valid = false;
            }
        },

    }
}