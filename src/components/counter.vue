<template>
    <div>
        <small class="text-muted position-absolute top-2 left-2 badge badge-pill badge-light">
            {{ time }}
        </small>
    </div>
</template>

<script>
    export default {
        name: "counter",
        props: ['timeleft'],
        data() {
            return {
                countdownInterval: null,
                time: '',
            }
        },
        mounted() {
            this.calculateTimesLeft();
            this.countdownInterval = setInterval(() => this.calculateTimesLeft(), 1000);
        },
        methods: {

            calculateTimesLeft() {
                this.time = getTimeLeft(this.timeleft);
            },

        },
        beforeDestroy() {
            clearInterval(this.countdownInterval);
        }

    }


    function getTimeLeft(end) {
        let left = '';
        let countDownDate = new Date(end).getTime();

        let now = new Date().getTime();

        let distance = countDownDate - now;

        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance < 0) {
            left = "EXPIRED";
        } else {
            left = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";
        }

        return left;
    }
</script>