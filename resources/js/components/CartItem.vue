<template>
    <div>
        <a class="product-card__btn select-btn mr-3" v-if="isCarted" @click.prevent="unCart(product)" href="javascript:void(0)">
               已加入購物車
        </a>
          <a class="product-card__btn mr-3" v-else @click.prevent="cart(product)" href="javascript:void(0)">
            <i class="fas fa-plus pr-2">加入購物車</i>
        </a>
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

                                        MessageObject.SuccessMessage("成功加入購物車");

                                         break;
                                       case "商品已存在於購物車":
            
                                        MessageObject.WarningMessage("商品已存在於購物車");

                                         break;
                                       default:
                                         this.isCarted = true;
                                         MessageObject.SuccessMessage("成功加入購物車");
                                         break;
                                        }
                                   })
                               .catch((error) => {
                                if(error.response.status === 404){
                                    Swal.fire({
                                    icon: 'error',
                                    title: '加入失敗',
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
                               MessageObject.SuccessMessage("成功移除");

                              })
                          .catch((error) => {
                                if(error.response.status === 404){
                                    swal.fire({
                                    icon: 'error',
                                    title: '移除失敗',
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
<style lang="scss" scoped>
$primary:#0f61f4;
$white:#fff;
.select-btn{
   border-radius:32px;
    text-align:center;
    white-space:nowrap;
    display:inline-flex;
    justify-content:center;
    align-items:center;
    color:$white;
    font-weight:600;
     background-color:#0f61f4;
     box-shadow:0 2px 10px 2px rgba(0,0,0,.1);
    transform:translateY(-3px);
    box-sizing:border-box;
    padding:0 2.5em;
    height:40px;
    text-transform:uppercase;
    letter-spacing:2px;
    font-size:10px;
   
}
</style>

