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
        user_id:this.auth!==0?this.auth.id:0,
        author:this.product_data.seller_id,
        product_id:this.product_data.id,
        comments:this._comments,
        auth_check: this.auth,
        the_switch:false,
        the_reply:false,
        edit_message:"",
        message: "",
        moment:moment,
      }
    },
    methods:{
        sendMessage() {
                if (this.message == '') {
                 MessageObject.VaildSubmitMessage('留言驗證錯誤','請勿無填寫內容或是少於兩字下按下送出喔');
                    return;
                }
                
                axios.post("http://localhost/campus2/public/comments/create", {
                    product_id: this.product_id,
                    content: this.message
                }).then((response) => {
                        this.message = '';
                        this.comments = response.data;
                    }).catch((error) => {
                             if(error.response.status === 404){
                                swal.fire({
                                  icon: 'error',
                                  title: '抱歉！此商品已遭下架',
                                  text: '系統將在您按下確認後跳至首頁',
                                  confirmButtonText: '確認',
                                  allowOutsideClick: false,      
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.fire({
                                    title: '系統重新整理中,請稍候',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                      swal.showLoading()
                                    },
                                    willClose: () => {
                                      window.location.href = '../'
                                    }
                              })
                          }
                    });
                }   
           });;

            },
            open(comment){
                    this.the_switch = comment.id;
                    // Remove my-component from the DOM
                    this.edit_message = comment.content;
            },
        editMessage(comment){
              if(this.edit_message.trim().length == 0){
                  MessageObject.VaildSubmitMessage('留言驗證錯誤','請勿無填寫內容或是少於兩字下按下送出喔');
                  return
              }

              axios.post(`http://localhost/campus2/public/comments/update/${comment.id}`, {
                    id: comment.id,
                    content: this.edit_message,
                }).then((response) => {
                        this.the_switch = false;
                        comment.content = response.data;
                    }).catch((error) => {
                             if(error.response.status === 404){
                                swal.fire({
                                  icon: 'error',
                                  title: '編輯失敗',
                                  text: '留言可能已遭刪除,系統在您按下確認後將自動重整',
                                  confirmButtonText: '確認',
                                  allowOutsideClick: false,      
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.fire({
                                    title: '系統重新整理中,請稍候',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                      swal.showLoading()
                                    },
                                    willClose: () => {
                                      window.location.reload();
                                    }
                              })
                          }
                       });
                    }
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
                    })
                   .catch((error) => {
                             if(error.response.status === 404){
                                swal.fire({
                                  icon: 'error',
                                  title: '回覆失敗',
                                  text: '留言可能遭刪除',
                                  footer:'<strong>系統將在您按下確認後進行自動重整</strong>',
                                  confirmButtonText: '確認',
                                  allowOutsideClick: false,      
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.fire({
                                    title: '系統重新整理中,請稍候',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                      swal.showLoading()
                                    },
                                    willClose: () => {
                                      window.location.reload(); //代改
                                    }
                              })
                          }
                    });
                }
           });
        },
        deleteReply(ids){
            
            swal.fire({
                    title: '確定要刪除此留言嗎?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                     axios.post(`http://localhost/campus2/public/comments/replies/${ids.id}`, {
                            id: ids.id,
                            product_id: ids.product_id,
                          }).then((response) => {
                        this.comments = response.data;
                 }).catch((error)=> {
                    if(error.response.status === 404){

                      MessageObject.ErrorMessage("刪除失敗","留言可能遭刪除,系統將在您按下確認後進行自動重整");
                    }

                 });
              }
          });
        },
        cancelReply(close){
           
           this.the_reply = close;

        },    
       deleteComment(comment){
         swal.fire({
                    title: '確定要刪除此留言嗎?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                     axios.post(`http://localhost/campus2/public/comments/${comment.id}`, {
                          id:comment.id,
                          product_id: comment.product_id,
                      }).then((response) => {
                        this.comments = response.data;
                  }).catch((error) => {
                             if(error.response.status === 404){
                                swal.fire({
                                  icon: 'error',
                                  title: '刪除失敗',
                                  text: '留言已遭刪除,系統將在您按下確認後進行自動重整',
                                  confirmButtonText: '確認',
                                  allowOutsideClick: false,      
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    swal.fire({
                                    title: '系統重新整理中,請稍候',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: () => {
                                      swal.showLoading()
                                    },
                                    willClose: () => {
                                      window.location.reload();
                                    }
                              })
                          }
                       });
                    }   
                });  
              }
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