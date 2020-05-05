<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-default" v-for="post in posts" :key="post.id">
                    <div class="panel-heading">
                        <img :src="post.user.avatar" alt="" width="40px" height="40px" class="avatar-feed">
                        {{ post.user.name }}
                        <span class="pull-right">
                            {{ post.created_at }}
                        </span>  
                    </div>
                    <div class="panel panel-body">
                        <p class="center">
                            {{ post.content }}
                        </p>
                        <like :id="post.id"></like>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import { Like } from "./Like.vue";
    export default {
        mounted () {
            this.get_feed();
        },
        methods: {
            get_feed() {
                this.$http.get('/feed')
                    .then( (resp) => {
                        console.log(resp);
                        if(resp.status === 200) {
                            if(resp.body) {
                                resp.body.forEach( (post) => {
                                    this.$store.commit('add_post', post)
                                });
                            }
                        }
                    })
            }
        },
        computed: {
            posts() {
                return this.$store.getters.all_posts
            }
        },
    }
</script>


<style>
    .avatar-feed {border-radius: 50%;}
</style>
