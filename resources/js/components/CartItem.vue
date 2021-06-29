<template>
    <div>
          <button class="btn btn-cart-select ml-2 mr-2" v-if="isCarted" @click.prevent="unCart(product)"><i class="fas fa-cart-plus pr-2"></i>已加入購物車</button>
          <button class="btn btn-cart ml-2 mr-2" v-else @click.prevent="cart(product)"><i class="fas fa-cart-plus pr-2"></i>加入購物車</button>
    </div>
</template>
<script>
export default {
        props: ['product', 'carted'],

        data: function() {
            return {
                isCarted: '',
            }
        },

        mounted() {
            this.isCarted = this.isCart ? true : false;

        },

        computed: {
            isCart() {
                return this.carted;
            },
        },

        methods: {
            cart(product) {
                    swal.fire({
                        icon: 'info',
                        title: '確定要將此商品加到購物車嗎?',
                        showCancelButton: true,
                        confirmButtonText: `加入購物車`,
                        }).then((result) => {
                        if (result.isConfirmed) {
                          axios.get('http://localhost/campus2/public/add-to-cart/', {
                                 params: {
                                    id: product
                                        }
                                    })
                               .then((response) => {
                                   switch(response.data){
                                       case "加入購物車成功":
                                            MessageObject.SuccessMessage(response.data);
                                         break;
                                       case "商品已存在於購物車":
                                            MessageObject.WarningMessage(response.data);
                                         break;
                                       default:
                                            this.isCarted = true;
                                            MessageObject.SuccessMessage(response.data);
                                         break;
                                        }
                                   })
                               .catch((error) => {
                                   console.log(error.response);
                                if(error.response.status === 403 || error.response.status === 404){
                                    MessageObject.ErrorMessage('收藏失敗',`${error.response.data},系統將在您按下確認後進行重新整理`);
                                }else{
                                    MessageObject.SystemError();
                                }
                            })
                        }
                    })
                },
            unCart(product) {
                swal.fire({
                    title: '確定將此商品從購物車移除嗎?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: '確定!'
                }).then((result) => {
                    if (result.isConfirmed) {
                     axios.delete('http://localhost/campus2/public/remove-from-cart/',{ params: { id: product } })
                          .then((response) => {
                              this.isCarted = false;
                               MessageObject.SuccessMessage(response.data);
                              })
                          .catch((error) => {
                                if(error.response.status === 403 || error.response.status === 404){
                                    MessageObject.ErrorMessage('收藏失敗',`${error.response.data},系統將在您按下確認後進行重新整理`);
                                }else{
                                    MessageObject.SystemError();
                                }
                            })    
                        }
                    })
                }
            }
        }
</script>
<style lang="scss" scoped>
    .btn-cart-select{
        background-color: #1761fd;
        color: #fff;
    }
</style>

