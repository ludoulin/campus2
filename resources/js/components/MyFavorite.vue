<template>
    <div>
        <a href="" class="btn btn-outline-danger" @click.prevent="unFavorite(product)"><i class="fas fa-heart pr-2"></i>移除收藏</a>
    </div>
</template>
<script>
let Swal = require("sweetalert2");
export default {
        props: ['product'],

        methods: {
            
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
                          .then( Swal.fire('移除成功!', '', 'success')
                                     .then((result) => {
                                         if (result.isConfirmed) {
                                                location.reload();    
                                                } 
                                     })
                          )
                          .catch(response => console.log(response.data));    
                  }
                })
            }
        }
    }
</script>

