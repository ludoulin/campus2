<template>
  <div>
    <input type="text" class="text campus-search-input" name="query" v-model="query" v-on:keyup="autoComplete" placeholder="搜尋商品、賣家、系所" autocomplete="off">
      <div class="panel-footer mt-1 campus-search-block" v-if="query.length">
      <ul class="list-group">
        <li class="list-group-item search-item"><i class="fas fa-search pr-2"></i>您正在搜尋"{{query}}"</li>
        <li class="list-group-item inner-search-item" v-for="result in results" :key="result.id" @click="redirectPath(result)">
            <i class="fas fa-book pr-2" v-if="result.price"></i>
            <i class="fas fa-user pr-2" v-if="result.email"></i>
            <i class="fas fa-school pr-2" v-if="result.college_id"></i>
              {{ result.name }}
        </li>
        <li class="list-group-item search-item" v-if="results.length === 0">
            <i class="fas fa-sad-tear pr-2"></i>查無任何結果....
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
 export default {
  data(){
   return {
    query: '',
    results: [],
    search:'',
   }
  },
  methods: {
   autoComplete(){
    // this.no_results = false;
    if(this.query.length > 0){
     axios.get('http://localhost/campus2/public/api/search',{params:{query: this.query}})
     .then(response => {
          this.results = response.data;
     });
    }
   },
   redirectPath(result){
      if(result.price)
      {
         window.location.href = "http://localhost/campus2/public/products/"+result.id

      }else if(result.email)
      {
        window.location.href = "http://localhost/campus2/public/users/"+result.id
      }else
      {
           window.location.href = "http://localhost/campus2/public/department/"+result.id
      }
   },
   clickSearch(){
        axios.post('http://localhost/campus2/public/api/search',{params:{query: this.query}});
   }
  }
 }
</script>

<style lang="scss" scoped>

.campus-search-block {
    border: 1px solid gainsboro;
    width: 100%;
    position:absolute;
    .search-item, .inner-search-item{
      border: 0;
      border-radius:0;
    }
    .inner-search-item:hover{
      color: orange;
      cursor: pointer;
    }
}
</style>