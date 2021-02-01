<template>
    <div>
       <a class="btn saved" v-if="isFavorited" @click.prevent="unFavorite(product)">
                <i class="fas fa-heart pr-2"></i>取消收藏</a>
          <a class="btn save" v-else @click.prevent="favorite(product)">
            <i class="fas fa-heart pr-2"></i>加入收藏</a>
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
                                    confirmButtonText: `先登入`,
                                }).then((result) => {
                                if (result.isConfirmed) {
                                      window.location.href = 'http://localhost/campus2/public/login'
                                    } 
                                });
                }else{
                    //     axios.post('http://localhost/campus2/public/favorite/'+product)
                    //          .then(response => this.isFavorited = true)
                    //          .catch((error) => {
                    //             if(error.response.status === 401){
                    //                 Swal.fire({
                    //                 icon: 'error',
                    //                 title: '想收藏嗎？',
                    //                 text: '那麻煩先登入喔',
                    //             });
                    //     }
                    // })

                    Swal.fire({
                        icon: 'info',
                        title: '確定要收藏嗎?',
                        showCancelButton: true,
                        confirmButtonText: `收藏`,
                        }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                          axios.post('http://localhost/campus2/public/favorite/'+product)
                               .then(response => this.isFavorited = true)
                               .catch((error) => {
                                if(error.response.status === 401){
                                    Swal.fire({
                                    icon: 'error',
                                    title: '想收藏嗎？',
                                    text: '那麻煩先登入喔',
                                });
                        }
                    })
        
                                 Swal.fire('收藏成功!', '', 'success')
        

                          }
                        })


                }
            },

            unFavorite(product) {
                 Swal.fire({
                    title: '確定要取消收藏嗎?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: '確定!'
                }).then((result) => {
                    if (result.isConfirmed) {
                     axios.post('http://localhost/campus2/public/unfavorite/'+product)
                          .then(response => this.isFavorited = false)
                          .catch(response => console.log(response.data));    
    
                  Swal.fire('成功移除!', '', 'success')
                  }
                })
            }
        }
    }
</script>

