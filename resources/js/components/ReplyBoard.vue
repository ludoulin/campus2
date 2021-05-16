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
                                {{ reply.user.name }}
                            </a>
                            <span class="text-secondary"> • </span>
                            <span class="meta text-secondary" :title="reply.created_at">{{ moment(reply.created_at).fromNow()}}</span>
                            <div class="float-right">
                                <div class="dropdown">
                                    <button class="btn btn-lg dot" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" @click="reply_open(reply)" href="javascript:void(0)" v-if="reply_comment.user_id == reply_user.id && reply.user_id!==reply_user.id || reply_user.id == product_author && reply.user_id!==product_author"><i class="fas fa-reply pr-2"></i>回覆</a>
                                        <a class="dropdown-item" @click="edit(reply)" href="javascript:void(0)" v-if="reply.user_id == reply_user.id && the_switch!==reply.id"><i class="fas fa-edit pr-2"></i>編輯</a>
                                        <a class="dropdown-item" @click="reply_delete(reply)" href="javascript:void(0)" v-if="reply.user_id == reply_user.id && the_switch!==reply.id"><i class="fas fa-trash-alt pr-2"></i>刪除</a>
                                    </div>
                                </div>
                             <!-- <span class="meta" v-if="reply_comment.user_id==reply_user.id&&reply.user_id!==reply_user.id||reply_user.id==product_author&&reply.user_id!==product_author">
                                <button @click="reply_open(reply)" class="btn btn-primary btn-xs pull-left">
                                 <i class="fas fa-reply mr-2"></i>回覆
                                </button>
                            </span>    
                            <span class="meta reply-edit mr-3" @click="edit(reply)" v-if="reply.user_id==reply_user.id&&the_switch!==reply.id">
                                編輯
                            </span>
                            <span class="meta reply-delete" @click="reply_delete(reply)" v-if="reply.user_id==reply_user.id&&the_switch!==reply.id">
                                刪除
                            </span> -->
                            </div>
                        </div>
                        <div class="media-heading mt-1 mb-1 text-secondary" v-if="the_switch==reply.id">
                            <div class="row">
                                <input
                                    v-model="edit_message"
                                    type="text"
                                    name="edit_reply"
                                    placeholder="要編輯嗎..."
                                    class="form-control input_style">
                                <button class="btn btn-primary btn-xs pull-left ml-3" @click="edit_ReplyMessage(reply)">儲存</button>     
                                <button class="btn btn-secondary btn-xs pull-left ml-3" @click="edit_ReplyCancel(reply)">取消</button>     
                            </div>   
                        </div>
                        <div class="reply-content text-secondary" v-if="the_switch!==reply.id">
                            {{reply.reply_content}}
                        </div>   
                    </div> 
                </li>
                <hr> 
            </div>
        </ul>
        <ul class="list-unstyled ml-4" v-if="this.reply_comment.id==this.open || open_reply==this.reply_comment.id">
            <div>
                <li class="media">
                    <div class="media-left">
                        <a>
                            <img class="media-object img-thumbnail mr-3"  :src="reply_user.avatar" style="width:48px;height:48px;" />
                        </a>
                    </div>
                    <div class="media-body ml-2">
                        <div class="media-heading mt-1 mb-1 text-secondary">
                            <div class="row">
                                <input
                                    v-model="reply_message"
                                    type="text"
                                    name="reply"
                                    placeholder="趕快回應吧..."
                                    class="form-control input_style">
                                <button class="btn btn-primary btn-xs pull-left ml-3" @click="send">儲存</button>     
                                <button class="btn btn-secondary btn-xs pull-left ml-3" @click="reply_cancel">取消</button>    
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
props:['reply_comment','open','replies','reply_user','product_author'],
 data(){
      return{
        reply_message:"",
        edit_message:"",
        moment:moment,
        the_switch:false,
        open_reply:false,
      }
    },
 methods:{
     send(e){
         e.preventDefault();
         if (this.reply_message == '') {
             MessageObject.VaildSubmitMessage('留言驗證錯誤','請勿無填寫內容或是少於兩字下按下送出喔');
            return
        }
        this.$emit('send', {text:this.reply_message,id:this.reply_comment.id});
        this.reply_message = '';
    },
    reply_open(reply){
        this.open_reply = this.reply_comment.id;
    },        
    reply_cancel(){
        if(this.open==false){
           this.open_reply = false;
        }else{
            this.$emit('reply_cancel', false);
        }
    },
    reply_delete(reply){
       this.$emit('reply_delete', { id:reply.id, product_id:reply.product_id, comment_id:this.reply_comment.id });
    },
    edit(reply){
         this.the_switch = reply.id;
         this.edit_message = reply.reply_content;
        },
    edit_ReplyMessage(reply){
          if(this.edit_message.trim().length == 0){
                MessageObject.VaildSubmitMessage('留言驗證錯誤','請勿無填寫內容或是少於兩字下按下送出喔');
                  return
            }
          axios.post(`http://localhost/campus2/public/comments/replies/update/${reply.id}`, { id: reply.id, product_id:reply.product_id, comment_id:this.reply_comment.id, content: this.edit_message })
               .then((response) => {
                    this.the_switch = false;
                    reply.reply_content = response.data;
                }).catch((error)=> {
                    if(error.response.status === 404){
                        switch(response.data){
                            case "商品已不存在於平台":
                                MessageObject.ErrorMessage(error.response.data,'系統將在您按下確認後跳至首頁', '../');
                            break;
                            case "找不到此留言":
                                MessageObject.ErrorMessage('儲存失敗','留言可能已被刪除,系統將在您按下確認後進行重新整理');
                            break;
                            case "找不到此回覆":
                                MessageObject.ErrorMessage('儲存失敗','回覆可能已被刪除,系統將在您按下確認後進行重新整理');
                            break;
                        }
                    }
                    else if(error.response.status === 403){
                        MessageObject.ErrorMessage(error.response.data,'系統將在您按下確認後跳至首頁', '../');
                    }
            });
    },
    edit_ReplyCancel(reply){
           axios.post(`http://localhost/campus2/public/comments/replies/get/${reply.id}`, { reply_id: reply.id })
                .then((response) => {
                        this.the_switch = false;
                        reply.reply_content = response.data;
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
    .reply-cancel, .reply-delete, .reply-edit{
        cursor: pointer;
    }
    .dot{
      background: none;
    }
    .dot:hover{
      background: #f1f3f4;
    }
</style>