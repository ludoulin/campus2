<template>
    <div>
        <!-- <a href="" class="btn btn-outline-danger" @click.prevent="unFavorite(product)"><i class="fas fa-heart pr-2"></i>移除收藏</a> -->
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
                     axios.post('http://localhost/campus2/public/unfavorite/'+product)
                          .then( swal.fire('成功移除!', '', 'success')
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

