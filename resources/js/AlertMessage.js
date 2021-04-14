window.VaildSubmitMessage = (title,text) => {

    swal.fire({
        title: title,
        icon: 'error',
        confirmButtonText: '知道了',
        allowOutsideClick: false,
        text: text,
     });

}

window.MessageObject = {

    VaildSubmitMessage:function(title,text){

        swal.fire({
            title: title,
            icon: 'error',
            confirmButtonText: '知道了',
            allowOutsideClick: false,
            text: text,
         });

    },
   SuccessMessage:function(title){

     swal.fire({
        title: title,
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
        });
    },
    Waiting:function(title){

        swal.fire({
            icon:'info',
            title: title,
            allowOutsideClick: false,
            showConfirmButton: false,
            onOpen: function(){
                swal.showLoading();
            }
          });
      
    },  
  WarningMessage:function(title){

    swal.fire({
        title: title,
        icon: 'warning',
        timer: 2000,
        showConfirmButton: false
        });
    },
  ErrorMessage:function(title,text){

                swal.fire({
                    icon: 'error',
                    title: title,
                    text: text,
                    confirmButtonText: '確認',
                    allowOutsideClick: false,      
                }).then((result) => {
                if (result.isConfirmed) {
                   this.SystemReload();
                }
            });
        },
    SystemReload:function(){

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
        },
    SystemError:function(){

        swal.fire({
            title: '系統異常',
            text:"於2秒後進行重整",
            icon: 'warning',
            timer: 2000,
            showConfirmButton: false
        });
        setTimeout(() => {
            window.location.reload();
         }, 2000);

    },
  OtherMessage:function(icon,title,text,ButtonText="ok"){

    swal.fire({
        icon: icon,
        title: title,
        text: text,
        confirmButtonText: ButtonText,
        allowOutsideClick: false, 
        });
  },
  checkMessage:function(title,text,something){
    swal.fire({
        icon: 'warning',
        title: title,
        text: text,
        confirmButtonText: '確認',
        allowOutsideClick: false,      
    }).then((result) => {
    if (result.isConfirmed) {
           something();
    }
});


  }  

}


