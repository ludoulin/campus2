<template>
    <div>
          <ul class="list-unstyled ml-4">
              <div v-for="reply in replies" :key="reply.id">
                    <li class="media">
                        <div class="media-left">
                            <a :href="`http://localhost/campus2/public/users/${reply.user_id}`">
                            <img class="media-object img-thumbnail mr-3"  :src="reply.user.avatar" style="width:48px;height:48px;" />
                            </a>
                        </div>
                        <div class="media-body ml-2">
                             <div class="media-heading mt-0 mb-1 text-secondary">
                                <a :href="`http://localhost/campus2/public/users/${reply.user_id}`" :title="reply.user.name">
                                    {{ reply.user.name }}--{{open}}
                                </a>
                             <span class="text-secondary"> • </span>
                            <span class="meta text-secondary" :title="reply.created_at">{{ moment(reply.created_at).fromNow()}}</span>
                
                         </div>
                            <div class="reply-content text-secondary" >
                                {{reply.reply_content}}
                         </div>   
                        </div> 
                    </li>
                  <hr> 
              </div>
          </ul>
          <ul class="list-unstyled ml-4" v-show="this.reply_comment_id==this.open">
              <div>
                    <li class="media">
                        <div class="media-left">
                            <a >
                            <img class="media-object img-thumbnail mr-3"  :src="reply_avatar" style="width:48px;height:48px;" />
                            
                            </a>
                        </div>
                        <div class="media-body ml-2">
                            <div class="media-heading mt-1 mb-1 text-secondary">
                                 <div class="row">
                                        <input
                                            @keyup.enter="send"
                                            v-model="reply_message"
                                            type="text"
                                            name="reply"
                                            placeholder="趕快回應買家吧..."
                                            class="form-control input_style">
                                        <span class="reply-cancel mt-1 ml-3 meta" @click="reply_cancel">取消</span> 
                                 </div>   
                            </div>
                        </div>    
                    </li>
                  <hr> 
              </div>
          </ul>
    </div>
</template>
<script>
let moment = require('moment');
 export default {
props:['comment_id','reply_auth_avatar','open'],
 data(){
      return{
        reply_message:"",
        moment:moment,
        reply_comment_id:this.comment_id,
        reply_avatar:this.reply_auth_avatar,
        replies:null,
      }
    },
 methods:{
     send(e) {
                e.preventDefault();
                
                if (this.reply_message == '') {
                    return;
                }

                this.$emit('send', {text:this.reply_message,id:this.reply_comment_id});
                this.reply_message = '';
            },
    reply_cancel(){

        this.$emit('reply_cancel', false);

    }        
               
    },
  created(){

   axios.post("http://localhost/campus2/public/comments/replies/get", {
                    id: this.reply_comment_id
                }).then((response) => {
                        this.replies = response.data;
                        console.log(this.replies);
                        console.log(123);

                    });

 },

 }   
</script>
<style lang="scss" scoped>
.input_style{
    width: 50%;
    border-radius: 30px !important;
}

.reply-cancel{
cursor: pointer;
}


</style>