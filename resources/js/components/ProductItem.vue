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
  <hr/>
        <div class="row row-eq-height">
          <div data-aos="zoom-in" class="col-12 col-md-6 col-lg-4 col-xl-3 mb-5" v-for="product in products" :key="product.id">
            <div class="product-card h-100 mb-0">
              <a class="product-card__content" :href="`http://localhost/campus2/public/products/${product.id}`">
                <span class="product-card__img" :style="{backgroundImage:'url(\'' + '../' + product.images[0].path + '\')'}"></span>
                  <span class="product-card__title">
                    {{product.name}}
                  </span>
                  <span class="product-card__price">
                    ${{product.price}}
                  </span>
                  <span class="product-card__title">
                    賣家:{{product.user.name}} 
                 </span>
              </a>
              <div class="product-card__actions">
                <cart-item
                  :product="product.id"
                  :carted="product.carted.length ? true : false "
                  ></cart-item>
                <favorite-circle
                :login="login"
                :product="product.id"
                :favorited="product.favorited.length ? true : false "
                ></favorite-circle>
              </div>
            </div>
          </div>
        </div>
        <div data-aos="zoom-in" v-if="no_products===true">
             <h1><i class="far fa-frown pr-2"></i>目前沒有二手書上架</h1>
         </div>
          <div data-aos="zoom-in" v-if="no_result===true">
             <h1><i class="far fa-frown pr-2"></i>抱歉...沒有您要查詢的結果</h1>
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

        }
    }
}
</script>