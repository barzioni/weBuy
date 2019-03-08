import Vue from 'vue';

import config from './config';
import translate from "./localData/translate";

export default Vue.mixin({
    data() {
        return {
            baseUrl: config.baseURL,
            lang: 'he',
        }
    },
    methods: {
        t(str) {
            let target = translate[this.lang][str];
            if (target) {
                return target;
            } else {
                return str;
            }
        }, log(arg) {
            console.log('======================================');
            if (typeof arg !== 'object') {
                console.log('Arg: ' + arg);
            } else {
                console.log('Is object:');
                console.log(arg);
            }
            console.log('Type: ' + typeof arg);
            console.log('======================================');
        },
    }
});