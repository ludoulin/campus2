<template>
   <div>
      <button class="btn btn-secondary dropdown-toggle notif" @click="markNotificationAsRead" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-bell mr-1"></i><a class="count">{{ notification_count }}</a></button>  
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
         <notification-item v-for="unread in unreadNotifications" :unread="unread" :key="unread.id"></notification-item>
         <div class="dropdown-item full-replay"><a href="http://localhost/campus2/public/notifications/index">查看所有回覆</a></div>
      </div>
   </div>
</template>
<script>
//  import ReadNotification from './ReadNotification'
 import NotificationItem from './NotificationItem'
 export default {
  props:['unreads', 'userid', 'reads', 'counts',],
  components:{NotificationItem},
  data(){
      return{
          unreadNotifications: this.unreads,
          Notifications: this.reads,
          notification_count: this.counts,
      }
  },
  methods: {
     markNotificationAsRead(e){

          e.preventDefault();

         if(this.notification_count!==0){
            
            axios.get('http://localhost/campus2/public/notifications/reset')
                 .then((response) => {
                        this.notification_count = response.data;
                    })

         }else{

            console.log(this.notification_count);

         }
     }
  },
  created(){
   console.log('Component mounted. ');
   Echo.private('App.Models.User.' + this.userid)
     .notification((notification) => {
       console.log(notification);
       let newunreadNotifications;
       if(notification.hasOwnProperty('comment_reply_id')){
          newunreadNotifications = {
            id:notification.id, 
            data:{
                comment_reply_id: notification.comment_reply_id,
                content:notification.content,
                user_id: notification.user_id,
                user_name: notification.user_name,
                user_avatar: notification.user_avatar,
                product_link: notification.product_link,
                product_id: notification.product_id,
                product_name:notification.product_name,
               },
               read_at:null
         };
           console.log(newunreadNotifications);
       }else{
            newunreadNotifications = {
               id:notification.id, 
               data:{
                      reply_id: notification.reply_id,
                      reply_content: notification.reply_content,
                      user_id: notification.user_id,
                      user_name: notification.user_name,
                      user_avatar: notification.user_avatar,
                      product_link: notification.product_link,
                      product_id: notification.product_id,
                      product_name:notification.product_name,
                    },
                     read_at:null
                  };
            }
       this.unreadNotifications.splice(0,0,newunreadNotifications);
       this.notification_count++

      this.Notifications.splice(0,0,newunreadNotifications);
   

     });

  }
 }
</script>


<style lang="scss" scoped>
.dropdown-menu {
  max-height:500px; 
  overflow: scroll;

}
</style>

