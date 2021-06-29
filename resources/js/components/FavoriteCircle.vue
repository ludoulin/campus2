<template>
    <div>
        <button class="btn btn-favorite-select ml-2" v-if="isFavorited" @click.prevent="unFavorite(product)"><i class="far fa-heart pr-2"></i>已收藏</button>
        <button class="btn btn-favorite ml-2" v-else @click.prevent="favorite(product)"><i class="far fa-heart pr-2"></i>加入收藏</button>
    </div>
</template>
<script>
// let Swal = require("sweetalert2");
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
                    MessageObject.AuthMessage("想收藏嗎？", "http://localhost/campus2/public/login");
                }else{
                    swal.fire({
                        icon: 'info',
                        title: '確定要收藏嗎?',
                        showCancelButton: true,
                        confirmButtonText: `收藏`,
                        cancelButtonText: '取消',
                        }).then((result) => {
                        if (result.isConfirmed) {
                          axios.get('http://localhost/campus2/public/favorite/', {
                                 params: {
                                    id: product
                                        }})
                               .then((response) => { 
                                   this.isFavorited = true;
                                   if(window.location.href === 'http://localhost/campus2/public/'){
                                    swal.fire(response.data, '', 'success').then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();    
                                      } 
                                });
                            }else{
                                    MessageObject.SuccessMessage(response.data);
                                }
                               }).catch((error) => {
                                   if(error.response.status === 403 || error.response.status === 404){
                                       MessageObject.ErrorMessage('收藏失敗',`${error.response.data},系統將在您按下確認後進行重新整理`);
                                   }else{
                                       MessageObject.SystemError();
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
                     axios.delete('http://localhost/campus2/public/unfavorite/',{
                            params: {
                                    id: product
                                 }
                            })
                          .then((response) => {
                                this.isFavorited = false;
                                if(window.location.href === 'http://localhost/campus2/public/'){
                                    swal.fire(response.data, '', 'success').then((result) => {
                                    if (result.isConfirmed) {
                                         location.reload();    
                                        } 
                                    });
                                }else{
                                    MessageObject.SuccessMessage("成功移除");
                                }
                        }).catch((error) => {
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

<style lang="scss" scoped>
.btn-favorite-select{
   background-color: #ff173c;
  color: #fff;
}
</style>