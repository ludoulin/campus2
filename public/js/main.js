function markNotificationAsRead(notificationCount){
  if(notificationCount !=='0'){
    $.get('http://localhost/campus2/public/markAsRead');
  }

}