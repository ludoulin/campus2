<template>
    <div>
    <div class="dropdown-item" :class='{"unread":unread.read_at==null}' v-on:click="select(unread)"> 
      <div class="media">
        <div class="media-left">
          <a>
            <img class="media-object mr-3" alt="" :src="image" style="width:48px;height:48px;" />
          </a>
        </div>
      
        <div class="media-body">
          <div class="media-heading mt-0 mb-1 text-secondary">
            <a>{{ unread.data.user_name }}</a>
            回覆了您的
            <a >{{ unread.data.product_name }}</a>
          </div>
          <div class="reply-content">
            {{unread.data.reply_content}}
          </div>
        </div>
    </div>
</div>
<hr>
    </div>
</template>
<script>
  export default {
    props:['unread'],
    data(){
      return{
        image:this.unread.data.user_avatar,
        url:this.unread.data.product_link
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

                    // window.location.hash = this.url.split("?")[1];

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
   background-color: aquamarine;
}
</style>