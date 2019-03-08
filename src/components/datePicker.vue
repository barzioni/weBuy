<template>
    <div>
        <div class="btn-cta" @click="$refs.datepicker.showCalendar()">
            <i class="ion ion-md-calendar i-lg"></i>
        </div>
        <datepicker
                :language="language"
                :disabledDates="disabledDates"
                @input="$emit('setTimeLeft', $event)"
                ref="datepicker">
        </datepicker>
    </div>
</template>


<script>
    //https://github.com/charliekassel/vuejs-datepicker
    import Datepicker from 'vuejs-datepicker';
    import {he, es} from 'vuejs-datepicker/dist/locale'

    export default {
        name: "datePicker",
        components: {Datepicker},
        created() {
            switch (this.lang) {
                case 'he':
                    this.language = he;
                    break;
                case 'es':
                    this.language = es;
                    break;
                default:
                    this.language = he
            }
        },
        data() {
            return {
                date: new Date(),
                disabledDates: {
                    to: new Date(),
                },
                language: null
            }
        },
    }
</script>

<style>
    .vdp-datepicker input {
        display: none;
    }

    .vdp-datepicker__calendar {
        position: fixed;
        top: 20%;
        left: 50%;
        transform: translate(-50%, 0%);
    }
</style>
