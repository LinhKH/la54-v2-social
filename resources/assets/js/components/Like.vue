<template>
  <div>
      <hr>
      
        <img :src="like.user.avatar" alt="" width="40px" height="40px" class="avatar-feed" v-for="like in post.likes" :key="like.id">
      
      <hr>
      <button class="btn btn-primary" v-if="!auth_user_likes_post" @click="like()">
          Like this post
      </button>
      <button class="btn btn-danger" v-else @click="unlike()">
          Unlike this post
      </button>
  </div>
</template>

<script>
export default {
    mounted () {
        
    },
    props: ['id'],
    computed: {
        likers() {
            var likers = [];

            this.post.likes.forEach(like => {
                likers.push(like.user.id);
            });
            return likers;
        },
        auth_user_likes_post() {
            var check_index = this.likers.indexOf(this.$store.state.auth_user.id);
            if(check_index === -1) {
                return false;
            } else {
                return true;
            }
        },
        post() {
            return this.$store.state.posts.find( (post) => {
                return post.id === this.id
            })
        }
    },
    methods: {
        like() {
            this.$http.get('/like/'+this.id)
                .then( (resp) => {
                    this.$store.commit('update_post_likes', {
                        post_id: this.id,
                        like: resp.body
                    })

                    new Noty({
                            type: 'success',
                            layout: 'bottomRight',
                            text: 'You successfully liked the post!',
                            timeout: 3000
                        }).show();
                })
        },
        unlike() {
            this.$http.get('/unlike/'+this.id)
                .then( (resp) => {
                    this.$store.commit('unlike_post', {
                        post_id: this.id,
                        like_id: resp.body
                    })

                    new Noty({
                            type: 'success',
                            layout: 'bottomRight',
                            text: 'You successfully unliked the post!',
                            timeout: 3000
                        }).show();
                })
        }
    },
};
</script>
