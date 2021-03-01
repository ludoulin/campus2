<template>
    <div>
       <a class="btn saved" v-if="isFavorited" @click.prevent="unFavorite(product)">
                <i class="fas fa-heart pr-2"></i>取消收藏</a>
          <a class="btn save" v-else @click.prevent="favorite(product)">
            <i class="fas fa-heart pr-2"></i>加入收藏</a>
    </div>
</template>
<script>
export default {
        props: ['product', 'favorited', 'login'],

        data: function() {
            return {
                isFavorited: '',
                auth:this.login,
            }
        },

        mounted() {
            this.isFavorited = this.isFavorite ? true : false;

        },

        computed: {
            isFavorite() {
                return this.favorited;
            },
        },

        methods: {
            favorite(product) {
                if(this.auth === 0){
                      swal.fire({
                        icon: 'info',
                        title: '想收藏嗎？',
                        text: '那麻煩先登入喔!',
                        showCancelButton: true,
                        cancelButtonText: '取消',
                        confirmButtonText: `先登入`,
                        }).then((result) => {
                    if (result.isConfirmed) {
                            window.location.href = 'http://localhost/campus2/public/login'
                        } 
                     });
                }else{
                    swal.fire({
                        icon: 'info',
                        title: '確定要收藏嗎?',
                        showCancelButton: true,
                        confirmButtonText: `收藏`,
                        cancelButtonText: '取消',
                        }).then((result) => {
                        if (result.isConfirmed) {
                          axios.post('http://localhost/campus2/public/favorite/'+product)
                               .then((response) => { 
                                   this.isFavorited = true;
                                MessageObject.SuccessMessage("成功加入購物車");

                               }).catch((error) => {
                                 switch(error.response.status){
                                 case 401:
                                      swal.fire({
                                        icon: 'error',
                                        title: '想收藏嗎？',
                                        text: '那麻煩先登入喔',
                                    });
                                    break;
                                case 404:
                                     swal.fire({
                                        icon: 'warning',
                                        title: '商品已售出或下架',
                                        text: '系統將在您按下確認後自動重整',
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
                                   break;
                                   default:
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
                                   break;    
                                }
                            })
                        }
                    })
               }
         },
            unFavorite(product) {
                swal.fire({
                    title: '確定要取消收藏嗎?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '確定',
                    cancelButtonText: '取消',
                }).then((result) => {
                    if (result.isConfirmed) {
                     axios.post('http://localhost/campus2/public/unfavorite/'+product)
                          .then((response) => {
                              this.isFavorited = false;
                             MessageObject.SuccessMessage("成功移除");

                        }).catch((error) => {
                             swal.fire({
                                  icon: 'warning',
                                  title: '商品已售出或下架',
                                  text: '系統將在您按下確認後自動重整',
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
                       });    
                    }
               })
            }
        }
    }
</script>

