<template>
<div>
<div class="container my-3">
  <div class="mb-3">
        <div class="form-row">
          <div class="col-md-9">
            <div class="form-row">
              <div class="col-auto"><input type="text" class="form-control form-control-sm"  v-model="keywords" placeholder="搜尋"></div>
              <div class="col-auto"><button class="btn btn-primary btn-sm" @click="searchProducts">搜尋</button></div>
            </div>
          </div>
          <div class="col-md-3">
            <select v-model="order" class="form-control form-control-sm float-right">
              <option value="">排序方式</option>
              <option value="price_asc">價格低到高</option>
              <option value="price_desc">價格高到低</option>
              <option value="created_at_hour">過去一小時</option>
              <option value="created_at_day">過去一天</option>
              <option value="created_at_week">過去一星期</option>
              <option value="created_at_month">過去一個月</option>
              <option value="created_at_desc">刊登時間新到舊</option>
              <option value="created_at_asc">刊登時間舊到新</option>
            </select>
          </div>
        </div>
  </div>
  <hr>
        <div class="row">
            <div class="col-md-3 mt-2" v-for="product in products" :key="product.id">
                <div class="card">
                    <div class="card-body">
                        <a :href="`../products/${product.id}`">
                            <img :src="'../'+product.images[0].path" alt class="d-block mx-auto my-4" height="150">
                        </a>
                        <p class="title-text overflow-ellipsis">書名:{{product.name}}</p>
                         <p class="title-text">賣家:{{product.user.name}}</p>
                        <div class="row my-4">
                            <div class="col">
                                <h4><span class="badge badge-primary mb-2">{{productType(product.type)}}</span></h4>
                                <h4><span class="badge badge-success mb-2">{{productStatus(product.status)}}</span></h4>  
                            </div>
                            <div class="col-auto">
                                <h5 class="text-muted mt-0">${{product.price}}</h5>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <favorite-circle :login="login" :product="product.id" :favorited="product.favorited.length ? true : false "></favorite-circle>
                            <cart-item :product="product.id" :carted="product.carted.length ? true : false "></cart-item>
                        </div>
                    </div>
                </div>
            </div>
            <div data-aos="zoom-in" class="col-sm-12 col-md-12 col-lg-12" v-if="no_products===true">
                 <h1 class="text-center"><i class="far fa-frown pr-2"></i>目前沒有任何書品上架</h1>
            </div>
            <div data-aos="zoom-in" class="col-sm-12 col-md-12 col-lg-12" v-if="no_result===true">
                <h1 class="text-center"><i class="far fa-frown pr-2"></i>沒有任何您要查詢的結果</h1>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import FavoriteCircle from './FavoriteCircle';
export default {
    props: ['login','department'],
    components:{ FavoriteCircle },
 data(){
        return{
            products:[],
            keywords:'',
            order:'',
            no_result:false,
            no_products:false,
            }
        },
 created(){
   this.fetchProducts();

 },
 watch:{
          order(after,before){
            this.searchProducts();
          }
        },
 methods: {
        fetchProducts() {
                axios.get('http://localhost/campus2/public/department/products/search',{params:{keywords: this.keywords, order:this.order,department:this.department}}).then(response => {
                    this.products = response.data;
                    if(this.products.length==0){
                        this.no_products = true;
                    }else{
                        this.no_products = false;
                    }
                });
        },
        searchProducts(){

           axios.get('http://localhost/campus2/public/department/products/search',{params:{keywords: this.keywords, order:this.order,department:this.department}}).then(search => {
                    this.products = search.data;
                    if(this.products.length==0){
                        this.no_result = true;
                    }else{
                        this.no_result = false;
                    }
                });

        },

        productType(type){

           let name = null;

           switch (type) {
            case 1:
                name = "參考書"
                break;
            case 2:
                name = "講義"
                break
            case 3:
                name ="筆記"
                break;
            }
            return name;
       },

       productStatus(status){

           let name = null;

           switch (status) {
            case 0:
                name = "下架"
                break;
            case 1:
                name = "上架中"
                break
            case 2:
                name ="進入交易程序"
                break;
            case 3:
                name ="已售出"
                break;    
            }
            return name;
       } 
    }
}
</script>