@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/product/index.css') }}" rel="stylesheet">
@endsection


@section('content')
<all-product :login="{{ Auth::check() ? 1 : 0 }}"></all-product>
{{-- <div class="container-fluid my-3">
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
                                        <select class="form-control form-search-control bg-white border-0" id="FormControlSelect1">
                                            <option>請選擇拍賣類型</option>
                                            <option>參考書</option>
                                            <option>講義</option>
                                            <option>筆記</option>            
                                        </select>   
                                    </div>   
                                </div>   
                            </li>
                            <li class="search-menu-opt">
                                <div class="product-dropdown">
                                    <div class="form-group mb-0">
                                        <select class="form-control form-search-control bg-white border-0" id="FormControlSelect2">
                                            <option>請選擇課程分類</option>
                                            <option>專業科目</option>
                                            <option>共同科目</option>
                                            <option>通識課程</option>
                                            <option>語言相關</option>
                                            <option>其他</option>            
                                        </select>   
                                    </div>   
                                </div>   
                            </li>
                            <li class="search-menu-opt">
                                <div class="product-dropdown">
                                    <div class="form-group mb-0">
                                        <select class="form-control form-search-control bg-white border-0" id="FormControlSelect3">
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
                                         <form action="#" class="searchbox">
                                             <input type="text" class="text search-input" placeholder="可搜尋書名、賣家">
                                             <a class="search-link" href="#">
                                                <i class="fas fa-search"></i>
                                             </a>    
                                         </form>
                                         <button type="submit" class="btn btn-primary search-data ml-2">搜尋</button>       
                                </div>   
                            </li>                
                        </ul>    
                    </div>    
                </div>
            </div>
            <div class="product-card">
                <div class="product-card-body"> 
                    <div class="row">
                        @foreach($products as $product)
                        <div data-aos="fade-down" class="col-sm-6 col-md-4 col-lg-3">
                            <div class="product-card product-card-block product-card-stretch product-card-height search-bookcontent">
                                <div class="product-card-body p-0">
                                    <div class="d-flex align-items-center">
                                        <div class="col-6 p-0 position-relative image-overlap-shadow">
                                            <a href="javascript:void(0);">
                                            <img class="img-fluid rounded w-100" src="{{url($product->images[0]->path)}}" alt>
                                            </a>
                                            <div class="view-book">
                                                <a href="{{route('products.show', $product->id)}}" class="btn btn-sm btn-white">前往商品頁面</a> 
                                            </div>        
                                        </div> 
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <p class="mb-1">{{$product->name}}</p>
                                                <p class="line-height mb-1 text-muted">賣家:{{$product->user->name}}</p>
                                            </div>
                                            <div class="price d-flex align-items-center">
                                                <p>
                                                    <b class="text-danger">${{$product->price}}元</b>
                                                </p>    
                                            </div>
                                            <div class="product-action">
                                                <a href="javascript:void(0);">
                                                    <i class="fas fa-cart-plus text-primary"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="ml-2">
                                                    <i class="fas fa-heart text-danger"></i>
                                                </a>      
                                            </div>           
                                        </div>       
                                    </div>    
                                </div>    
                            </div>    
                        </div> 
                        @endforeach
                    </div>    
                </div>
            </div>      
        </div>    
    </div>
</div> --}}
@endsection

@section('script')
<script>
    AOS.init();
</script>
@endsection

{{-- <div class="d-block">
        <span>
        </span>    
</div>     --}}

