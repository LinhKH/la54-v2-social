<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <textarea v-model="content" rows="5" class="form-control" style="resize:vertical"></textarea>
                        <br>
                        <button class="btn btn-success pull-right" :disabled="not_working" @click="create_post()">
                            Create a post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted () {
            
        },
        data() {
            return {
                content: '',
                not_working: true
            }
        },
        watch: {
            content() {
                if (this.content.length > 0) {
                    this.not_working = false;
                } else {
                    this.not_working = true;
                }
            }
        },
        methods: {
            create_post() {
                this.$http.post('create/post', { content: this.content })
                    .then( (resp) => {
                        if(resp.status === 200) {
                            this.content = '';
                            new Noty({
                                type: 'success',
                                layout: 'bottomRight',
                                text: "Your post has been published !",
                            }).show();
                        }
                    })
            }
        },
    }
</script>
