<template>
    <div>
        <button type="button" class="btn carted" v-if="isCarted" @click.prevent="unCart(product)">
            已加入購物車
        </button>
         <button type="button" class="btn cart" v-else @click.prevent="cart(product)">
            <i class="fas fa-plus pr-2">加入購物車</i>
        </button>
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
                          axios.get('http://localhost/campus2/public/products/add-to-cart/', {
                                 params: {
                                    id: product
                                        }
                                    })
                               .then((response) => {
                                   switch(response.data){
                                       case "加入購物車成功":
                                         swal.fire({
                                            title: '成功加入購物車',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                         break;
                                       case "商品已存在於購物車":
                                           swal.fire({
                                                title: '商品已存在於購物車',
                                                icon: 'warning',
                                                timer: 2000,
                                                showConfirmButton: false
                                            });
                                         break;
                                       default:
                                         this.isCarted = true;
                                         swal.fire({
                                            title: '成功加入購物車',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                         break;
                                        }
                                   })
                               .catch((error) => {
                                if(error.response.status === 404){
                                    Swal.fire({
                                    icon: 'error',
                                    title: '發生錯誤？',
                                    text: '商品可能已賣出或下架',
                                    });
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
                     axios.delete('http://localhost/campus2/public/remove-from-cart/',{params: {id: product}})
                          .then((response) => {
                              this.isCarted = false;
                               swal.fire({
                                    title: '成功移除',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                              })
                          .catch((error) => {
                                if(error.response.status === 404){
                                    swal.fire({
                                    icon: 'error',
                                    title: '發生錯誤？',
                                    text: '商品可能已賣出或下架',
                                    });
                                }
                             })    
                        }
                    })
                }
            }
        }
</script>
