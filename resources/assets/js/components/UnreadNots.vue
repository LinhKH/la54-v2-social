<template>
  <li>
      <a href="/notifications">Unread notification <span class="badge">{{ all_nots_count }}</span> </a>
  </li>
</template>

<script>
    export default {
        mounted () {
            this.get_unread()
        },
        methods: {
            get_unread() {
                this.$http.get('/get_unread')
                    .then( (nots) => {
                        console.log(nots);
                        if(nots.status === 200) {
                            nots.body.forEach( (not) => {
                                this.$store.commit('add_not', not)
                            });
                        }

                    })
            }
        },
        computed: {
            all_nots_count() {
                return this.$store.getters.all_nots_count 
            }
        },
    }
</script>
