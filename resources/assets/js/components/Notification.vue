<template>
    <div>

    </div>
</template>

<script>
    export default {
        mounted () {
            this.listen();
        },
        props: ['id'],
        methods: {
            listen() {
                console.log('notification component')
                Echo.private('App.User.' + this.id)
                    .notification((notification) => {
                        console.log(notification);
                        new Noty({
                            type: 'success',
                            layout: 'bottomRight',
                            text: notification.name + notification.message,
                        }).show();
                        this.$store.commit('add_not', notification)
                        document.getElementById('noty_audio').play()
                    });
            }
        },
    }
</script>