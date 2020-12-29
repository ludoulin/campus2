<template>
    <div>
        <ul class="list-unstyled">
          <div v-for="comment in comments" :key="comment.id"> 
          <li class="media" :name="`reply${comment.id}`" :id="`reply${comment.id}`">
            <div class="media-left">
              <a :href="`http://localhost/campus2/public/users/${comment.user_id}`">
                <img class="media-object img-thumbnail mr-3" alt="comment->user->name }}" :src="comment.user.avatar" style="width:48px;height:48px;" />
              </a>
            </div>
      
            <div class="media-body">
              <div class="media-heading mt-0 mb-1 text-secondary">
                <a :href="`http://localhost/campus2/public/users/${comment.user_id}`" :title="comment.user.name">
                  {{ comment.user.name }}
                </a>
                <span class="text-secondary"> • </span>
                <span class="meta text-secondary" :title="comment.created_at">{{ moment(comment.created_at).fromNow()}}</span>
                
                <div class="float-right" v-if="auth_check!==0">
                <span class="meta" v-if="author==user_id&&the_reply!==comment.id">
                      <button @click="open_reply(comment)" class="btn btn-primary btn-xs pull-left">
                      <i class="fas fa-reply mr-2"></i>回覆
                      </button>
                </span>    
                <span class="meta" v-if="comment.user_id==user_id&&the_switch!==comment.id">
                      <button @click="open(comment)" class="btn btn-success btn-xs pull-left">
                        <i class="far fa-edit mr-2"></i>編輯
                      </button>
                </span>
                <span class="meta" v-if="comment.user_id== user_id&&the_switch!==comment.id||author==user_id&&the_reply!==comment.id">
                      <button @click="deleteComment(comment)" class="btn btn-danger btn-xs pull-left">
                        <i class="far fa-trash-alt mr-2"></i>刪除
                      </button>
                </span>
                </div>
              </div>
               <div class="media-heading mt-0 mb-1 text-secondary" v-if="the_switch==comment.id">
                 <div class="row">
              <input
                    v-model="edit_message"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control input_style">
                 <button class="btn btn-primary btn-xs pull-left ml-3" @click="editMessage(comment)">儲存</button>     
                 <button class="btn btn-secondary btn-xs pull-left ml-3" @click="edit_cancel(comment)">取消</button>     
                <!-- <span v-if="the_switch==comment.id" @click="edit_cancel(comment)">取消</span> -->
                 </div>
               </div>
              <div class="reply-content text-secondary" v-if="the_switch!==comment.id" >
                {{comment.content}}
            </div>
           </div>
          </li>
          <hr>
          <!-- <div class="reply mb-3">
          <div class="user-reply" role="textbox" contenteditable style="outline: none; background:gray">
          </div>
          </div> -->
          <reply-board :reply_comment="comment"  :reply_user="auth_check" :product_author="author" @send="sendReply" @reply_delete="deleteReply" @reply_cancel="cancelReply" :open="the_reply" :replies="comment.replies"></reply-board>
          
          
        </div>
      </ul>
    <div class="reply-box" v-if="auth_check!==0">
        <div class="form-group">
      <textarea class="form-control" v-model="message" rows="3" placeholder="請在此輸入您的提問，賣家將會回覆您的提問~"></textarea>
    </div>
    <button @click="sendMessage" class="btn btn-primary btn-sm"><i class="fa fa-share mr-1"></i>確認送出</button>
   </div>
</div>
</template>
<script>
 let moment = require('moment');
 import ReplyBoard from './ReplyBoard'
  export default {
    props:['_comments','product_data','auth'],
    components:{ReplyBoard},
    data(){
      return{
        comments:this._comments,
        moment:moment,
        message: "",
        auth_check: this.auth,
        user_id:this.auth!==0?this.auth.id:0,
        author:this.product_data.seller_id,
        product_id:this.product_data.id,
        the_switch:false,
        edit_message:"",
        the_reply:false,
      }
    },
    methods:{
        sendMessage() {
                
                if (this.message == '') {
                    return;
                }
                
                axios.post("http://localhost/campus2/public/comments/create", {
                    product_id: this.product_id,
                    content: this.message
                }).then((response) => {
                        this.message = '';
                        this.comments = response.data;
                    });

            },
            open(comment){
                    this.the_switch = comment.id;
                    // Remove my-component from the DOM
                    this.edit_message = comment.content;
            },
        editMessage(comment){
              if(this.edit_message.trim().length == 0){
                  alert('內容都一定要填喔...');
                  return
              }

              axios.post(`http://localhost/campus2/public/comments/update/${comment.id}`, {
                    id: comment.id,
                    content: this.edit_message,
                }).then((response) => {
                        this.the_switch = false;
                        comment.content = response.data;
                    });


            },
        edit_cancel(comment){
               axios.post("http://localhost/campus2/public/comments/comment/get", {
                     id: comment.id,
                }).then((response) => {
                        this.the_switch = false;
                        comment.content = response.data;
                    });
          },
        open_reply(comment){
            this.the_reply = comment.id;
        },  
        sendReply(data){
           
                axios.post("http://localhost/campus2/public/comments/replies/create", {
                    comment_id: data.id,
                    product_id: this.product_id,
                    reply_content: data.text,
                }).then((response) => {
        
                        this.the_reply = false;
                        this.comments = response.data;
  
                    });
        },
        deleteReply(ids){

            axios.post(`http://localhost/campus2/public/comments/replies/${ids.id}`, {
                    id: ids.id,
                    product_id: ids.product_id,
                }).then((response) => {
                        this.comments = response.data;
                    });


        },
        cancelReply(close){
           
           this.the_reply = close;

        },    
       deleteComment(comment){
           axios.post(`http://localhost/campus2/public/comments/${comment.id}`, {
                    id:comment.id,
                    product_id: comment.product_id,

                }).then((response) => {
                        this.comments = response.data;
                    });
       }
    },
}
</script>
<style lang="scss" scoped>
.input_style{
    width: 50%;
    border-radius: 30px !important;
}

.reply{
    height: 40%;
    width: 80%;    
    background: rosybrown;    
    border-radius: 15px;
    padding: 8px;
.user-reply{
    height: inherit;
    text-align: initial;
            }
}

.reply-cancel{
cursor: pointer;
}


</style>

<!-- <div class="reply-input ml-4 mb-4">
              <div class="float-left">
              <a :href="`http://localhost/campus2/public/users/${user_id}`">
                <img class="media-object img-thumbnail mr-3" :src="auth_check.avatar" style="width:48px;height:48px;" />
              </a>
            </div>
            <div class="my-2">
           <input
             v-model="reply_message"
             type="text"
             name="message"
             placeholder="Enter your message..."
             class="form-control input_style">
               <div>取消1</div>
            </div>
             <hr> 
           </div>  -->

  <!-- board_check(){
    if(this.auth_check!==0){
        this.board = true ;

        }else{
            this.board = false;
             }
       }  -->         