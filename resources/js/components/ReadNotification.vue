<template>
    <div>
    <div class="dropdown-item" :class='{"unread":read.read_at==null}' v-on:click="select(read)"> 
      <div class="media">
        <div class="media-left">
          <a>
            <img class="media-object mr-3" alt="" :src="image" style="width:48px;height:48px;" />
          </a>
        </div>
      
        <div class="media-body">
          <div class="media-heading mt-0 mb-1 text-secondary">
            <a>{{ read.data.user_name }}</a>
            回覆了您的
            <a >{{ read.data.product_name }}</a>
          </div>
          <div class="reply-content">
            {{read.data.reply_content}}
          </div>
        </div>
    </div>
</div>
<hr>
    </div>
</template>
<script>
  export default {
    props:['read'],
    data(){
      return{
        image:this.read.data.user_avatar,
      }
    },
    methods:{
      select(read){
           
           if(read.read_at==null){
           let data = {
               id: read.id
           }
           axios.post('http://localhost/campus2/public/notifications/read', data);
                window.location.href = this.read.data.product_link;
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