<template>
    <div>
         <a href="javascript:void(0)" class="badge badge-danger" @click.prevent="unFavorite(product)"><i class="fas fa-times"></i></a> 
    </div>
</template>
<script>
export default {
        props: ['product'],

        methods: {
            unFavorite(product) {
                swal.fire({
                    title: '確定要取消收藏嗎?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '確定!'
                }).then((result) => {
                    if (result.isConfirmed) {
                     axios.delete('http://localhost/campus2/public/unfavorite/',{
                            params: {
                                    id: product
                                 }
                            })
                          .then((response) => { 
                              swal.fire(response.data, '', 'success')
                                  .then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();    
                                        } 
                                })
                          })
                          .catch((error) => {
                            if(error.response.status === 403 || error.response.status === 404){
                                 MessageObject.ErrorMessage('收藏失敗',`${error.response.data},系統將在您按下確認後進行重新整理`);
                            }else{
                                MessageObject.SystemError();
                            }
                       });    
                    }
                })
            }
        }
    }
</script>

