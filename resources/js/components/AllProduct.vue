<template>
    <div>
        <div class="container my-3">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-transparent mb-0">
                        <div class="d-block text-center">
                            <h2 class="mb-3">瀏覽全部商品</h2>
                            <div class="w-100 product-search-filter">
                                <ul class="list-inline p-0 m-0 row justify-content-center search-menu-options">
                                    <li class="search-menu-opt">
                                        <div class="product-dropdown">
                                            <div class="form-group mb-0">
                                                <select class="form-control form-search-control bg-white border-0" id="FormControlSelect1" v-model="productTypes">
                                                    <option value="">請選擇拍賣類型</option>
                                                    <option value="1">參考書</option>
                                                    <option value="2">講義</option>
                                                    <option value="3">筆記</option>            
                                                </select>   
                                            </div>   
                                        </div>   
                                    </li>
                                    <li class="search-menu-opt">
                                        <div class="product-dropdown">
                                            <div class="form-group mb-0">
                                                <select class="form-control form-search-control bg-white border-0" id="FormControlSelect2" v-model="courseTypes">
                                                    <option value="">請選擇課程分類</option>
                                                    <option value="1">專業科目</option>
                                                    <option value="2">共同科目</option>
                                                    <option value="3">通識課程</option>
                                                    <option value="4">語言相關</option>
                                                    <option value="5">其他</option>            
                                                </select>   
                                            </div>   
                                        </div>   
                                    </li>
                                    <li class="search-menu-opt">
                                        <div class="product-dropdown">
                                            <div class="form-group mb-0">
                                                <select class="form-control form-search-control bg-white border-0" id="FormControlSelect3" v-model="order">
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
                                    </li>
                                    <li class="search-menu-opt">
                                        <div class="product-search-bar search-book d-flex align-items-center">
                                                <div class="searchbox">
                                                    <input type="text" class="text search-input" placeholder="可搜尋書名、賣家" v-model="keywords">
                                                    <a class="search-link" href="#">
                                                        <i class="fas fa-search"></i>
                                                    </a>    
                                                </div>
                                                <button class="btn btn-primary search-data ml-2" @click="searchProducts">搜尋</button>       
                                        </div>   
                                    </li>                
                                </ul>    
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-3 mt-2" v-for="product in products" :key="product.id">
                            <div class="card">
                                <div class="card-body">
                                    <a :href="`./products/${product.id}`">
                                        <img :src="'./'+product.images[0].path" alt class="d-block mx-auto my-4" height="150">
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
                        <div data-aos="fade-down" class="col-sm-12 col-md-12 col-lg-12"  v-if="this.initResult===true">
                            <h1 class="text-center"><i class="far fa-frown pr-2"></i>目前沒有任何書品上架</h1>
                        </div>
                        <div data-aos="fade-down" class="col-sm-12 col-md-12 col-lg-12"  v-if="this.searchResult===true">
                            <h1 class="text-center"><i class="far fa-frown pr-2"></i>沒有任何您要查詢的結果</h1>
                        </div>
                    </div>
                    <pagination-component v-if="pagination.last_page > 0 && pagination.total > 0" :pagination="pagination" :offset="5" @paginate="changePage()"></pagination-component> 
                </div>    
            </div>
        </div>
    </div>    
</template>
<script>
import PaginationComponent from './PaginationComponent';
export default {
 props: ['login'],
 components:{ PaginationComponent },
 data(){
     return{
            products:{},
            pagination: {
            'current_page': 1
            },
            keywords:'',
            order:'',
            productTypes:'',
            courseTypes:'',
            initResult:false,
            searchResult:false,
            }
    },
created(){
   this.fetchProducts();
    },
methods: {
        fetchProducts() {
                axios.get('./products/search').then(response => {
                    this.products = response.data.data;
                    this.pagination = response.data;
                    console.log(response.data)
                    if(this.products.length==0){
                        this.initResult = true;
                    }else{
                        this.initResult = false;
                    }
            });
        },
        
        searchProducts(){

           axios.get('./products/search', {params:{keywords: this.keywords, order:this.order, product_type:this.productTypes, course_type:this.courseTypes}}).then(search => {
                    this.products = search.data.data;
                    this.pagination = search.data;
                    console.log(search.data)
                    if(this.products.length==0){
                        this.searchResult = true;
                    }else{
                        this.searchResult = false;
                    }
                });

        },

        changePage(){
            console.log(this.pagination.current_page);
            axios.get('./products/search?page=' + this.pagination.current_page , {params:{keywords: this.keywords, order:this.order, product_type:this.productTypes, course_type:this.courseTypes}}).then(response => {
                    this.products = response.data.data;
                    this.pagination = response.data;
                    console.log(response.data)
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

<!--<div class="row">
                                <div data-aos="fade-down" class="col-sm-6 col-md-4 col-lg-3" v-for="product in products" :key="product.id" >
                                    <div class="product-card product-card-block product-card-stretch product-card-height search-bookcontent">
                                        <div class="product-card-body p-0">
                                            <div class="d-flex align-items-center">
                                                <div class="col-6 p-0 position-relative image-overlap-shadow">
                                                    <a href="javascript:void(0);">
                                                    <img class="img-fluid rounded w-100" :src="'../public'+product.images[0].path" alt>
                                                    </a>
                                                    <div class="view-book">
                                                        <a :href="`http://localhost/campus2/public/products/${product.id}`" class="btn btn-sm btn-white">前往商品頁面</a> 
                                                    </div>        
                                                </div> 
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <p class="mb-1">{{product.name}}</p>
                                                        <p class="line-height mb-1 text-muted">賣家:{{product.user.name}}</p>
                                                    </div>
                                                    <div class="price d-flex align-items-center">
                                                        <p>
                                                            <b class="text-danger">${{product.price}}元</b>
                                                        </p>    
                                                    </div>
                                                    <div class="product-action">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 ">
                                                                <a href="javascript:void(0);" class="h-t">
                                                                    <i class="far fa-heart heart"><span>收藏</span></i>
                                                                </a>      
                                                            </div>
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                                                <a href="javascript:void(0);" class="c-t">
                                                                    <i class="fas fa-cart-plus cart"><span>加入購物車</span></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>           
                                                </div>       
                                            </div>    
                                        </div>    
                                    </div>    
                                </div> 
                            </div> 