<template>
    <div>
        <a class="select-icon-btn" v-if="isFavorited" @click.prevent="unFavorite(product)" href="">
                <i class="fas fa-heart"></i>
        </a>
          <a class="product-card__icon-btn" v-else @click.prevent="favorite(product)" href="">
            <i class="fas fa-heart"></i>
        </a>
    </div>
</template>
<script>
let Swal = require("sweetalert2");
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
                      Swal.fire({
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
                    Swal.fire({
                        icon: 'info',
                        title: '確定要收藏嗎?',
                        showCancelButton: true,
                        confirmButtonText: `收藏`,
                        cancelButtonText: '取消',
                        }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                          axios.post('http://localhost/campus2/public/favorite/'+product)
                               .then((response) => { 
                                   this.isFavorited = true;
                                   if(window.location.href === 'http://localhost/campus2/public/'){
                                    Swal.fire('收藏成功!', '', 'success').then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();    
                                      } 
                                });
                            }else{
                                     Swal.fire({
                                        title: '收藏成功',
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                }
                               }).catch((error) => {
                                switch(error.response.status){
                                 
                                 case 401:
                                      Swal.fire({
                                        icon: 'error',
                                        title: '想收藏嗎？',
                                        text: '那麻煩先登入喔',
                                    });
                                    break;
                                case 404:
                                     Swal.fire({
                                        icon: 'warning',
                                        title: '商品已售出或下架',
                                        text: '系統將在您按下確認後自動重整',
                                        confirmButtonText: '確認',
                                        allowOutsideClick: false,      
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                    Swal.fire({
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
                                            location.reload();
                                         }, 2000);
                                   break;    
                                }
                            })
                        }
                    })
               }
         },
            unFavorite(product) {
                Swal.fire({
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
                                    if(window.location.href === 'http://localhost/campus2/public/'){
                                        Swal.fire('成功移除!', '', 'success').then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();    
                                      } 
                                });
                            }else{
                                 Swal.fire({
                                    title: '成功移除',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                    });
                                }
                        }).catch((error) => {
                             Swal.fire({
                                  icon: 'warning',
                                  title: '商品已售出或下架',
                                  text: '系統將在您按下確認後自動重整',
                                  confirmButtonText: '確認',
                                  allowOutsideClick: false,      
                                }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
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
                            console.log(error);
                       });    
                    }
               })
            }
        }
    }
</script>

<style lang="scss" scoped>
$primary:#fb6969;
$white:#fff;
.select-icon-btn{
    color:$white;
    text-decoration:none;
    height:40px;
    width:40px;
    min-height:40px;
    min-width:40px;
    background-color:darken($primary, 5%);
    border-radius:100%;
    justify-content:center;
    align-items:center;
    display:flex;
    box-shadow:0 2px 5px 2px transparentize($primary,.4);
    transform:translateY(-3px);
}
</style>