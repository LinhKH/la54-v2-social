<template>
    <div class="container">
        <div class="row">
            <p>this is friend component vue</p>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.$http.get('/check_relationship_status/' + this.profile_user_id)
                .then( (resp) => {
                    console.log(resp);
                })
        },
        props: ['profile_user_id'],
    }
</script>
