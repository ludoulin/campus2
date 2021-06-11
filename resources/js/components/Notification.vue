<template>
      <li class="nav-item nav-icon" @click="markNotificationAsRead">
         <a href="javascript:void(0)" class="search-toggle campus-waves-effect text-gray rounded">
            <i class="far fa-bell"></i>
            <span class="badge badge-danger count-notify rounded-circle">{{ notification_count }}</span>
         </a>
         <div class="campus-sub-dropdown">
            <div class="campus-card shadow-none m-0">
               <div class="campus-card-body p-0">
                  <div class="bg-primary p-3">
                     <h5 class="mb-0 text-white">所有提醒<small class="badge  badge-light float-right pt-1">{{ unreadNotifications.length }}</small></h5>
                  </div>
                  <div style="overflow:scroll;max-height:280px;">
                      <notification-item v-for="unread in unreadNotifications" :unread="unread" :key="unread.id"></notification-item>
                  </div>
                  <div class="d-flex align-items-center text-center p-3">
                     <a class="btn btn-primary mr-2 campus-sign-btn" href="#" role="button">查看全部</a>
                  </div>
               </div>
            </div>
         </div>
      </li>
</template>
<script>

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


