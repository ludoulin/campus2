<script>
     $(function(){  
              $("#PayForm").submit(function(event) {
                  let form = $(this);
                  let url = form.attr('action');
                  event.preventDefault();
                  console.log($(this).serialize());
                  MessageObject.Waiting("下單中,請稍後");
                  $.ajax({
                          type: "POST",
                          url: url,
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                          data: form.serialize(),
                          success: function(response){
                                    text=(response.message==="面交付費下單成功") ? "訂單" : "付款";
                                    swal.close();
                                    swal.fire({
                                            icon:'success',
                                            title: '下單成功',
                                            text:`準備前往${text}頁面`,
                                            timer: 2000,
                                            timerProgressBar: true,
                                            didOpen: () => {
                                                            swal.showLoading();
                                                            },
                                            willClose: () => {
                                                            if(response.returnCode==="0000"){
                                                                window.location = response.info.paymentUrl.web
                                                            }else{
                                                                window.location = '{{route("users.orders_status", Auth::id())}}'
                                                            }
                                                        }
                                            });
                                        return true
                                      },
                        error: function (error) {
                            console.log(error);
                            MessageObject.ErrorMessage('下單失敗',`${error.responseText},系統將在您按下確認後跳至首頁`,'{{route("root")}}');
                            return false
                        }       
                    });
                }); 
          });    
    function Pay() {
        swal.fire({
                    title: "確認完成了嗎?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5b73e8',
                    confirmButtonText: '確定!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if(ValidateForm() && EmailVaild()){
                            $("#PayForm").submit();
                        }
                    } 
            });
    }
    function EmailVaild(){

        let EmailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        let email = document.getElementById("billing-email-address").value;

        $("#billing-email-address").removeClass("is-invalid");

        if(!EmailRegex.test(email)){
            $("#billing-email-address").addClass("is-invalid");
            MessageObject.VaildSubmitMessage("驗證錯誤","請輸入正確的email格式");
            return false
        }
        return true
    }    
</script>