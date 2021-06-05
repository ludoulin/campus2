<template>
    <div>
      <a href="javascript:void(0)" class="campus-sub-card" :class='{"unread":unread.read_at==null}' v-on:click="select(unread)">
        <div class="media align-items-center">
          <div>
            <img class="avatar-40 rounded" :src="image" alt="">
          </div>
          <div class="media-body ml-3" v-if="unread.data.hasOwnProperty('reply_id')==true">
            <h6 class="mb-0">{{ unread.data.user_name }}</h6>
            <small class="float-right font-size-12">Just Now</small>
            <p class="mb-0">回覆了您的 {{ unread.data.product_name }}</p>
             <p class="mb-0">{{unread.data.reply_content}}</p>
          </div>
          <div class="media-body ml-3" v-if="unread.data.hasOwnProperty('comment_reply_id')==true">
            <h6 class="mb-0">{{ unread.data.user_name }}</h6>
            <small class="float-right font-size-12">Just Now</small>
            <p class="mb-0">回覆了您的 {{ unread.data.product_name }}</p>
             <p class="mb-0"> {{unread.data.content}}</p>
          </div>
        </div>
      </a>
  </div>
</template>
<script>
  export default {
    props:['unread'],
    data(){
      return{
        image:this.unread.data.user_avatar,
        url:this.unread.data.product_link,
      }
    },
    methods:{
      select(unread){
           
           if(unread.read_at==null){

           let data = {
               id: unread.id
           }
        
           axios.post('http://localhost/campus2/public/notifications/read', data);
                 
                 if(window.location.href.split("?")[0]===this.url.split("?")[0]){
                    window.location.href = this.url.split("?")[0]+ this.url.split("?")[1];
                 }else{ 
                    window.location.href = this.unread.data.product_link;
                 }
            }         
        }
    }
}
</script>

<style lang="scss" scoped>
.unread {
   background-color: #d7f2f9;
}
</style>