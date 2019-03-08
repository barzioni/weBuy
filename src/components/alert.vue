<template>
    <div>
        <div class="alert app-alert text-right rounded-0"
             role="alert"
             :class="{'alert-danger': msg.type === 'error', 'alert-success': msg.type === 'success'}"
             v-if="msg.body" v-for="value in msg.body">
            {{value}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "alert",
        props:['msg']
    }
</script>