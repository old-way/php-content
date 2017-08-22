<template>
  <div class="article">
    <div class="top-title">
      <h1>Blog Small Image</h1>
      <p>Lorem ipsun dolor sit amet, feugiat delicata liberseid cumis.</p>
    </div>
    <div class="container main">
      <ul class="list-unstyled">
        <li v-for="item in articleList">
          <div class="row">
            <div class="col-md-1 text-center date">
              <h2>{{ new Date(item.created_at).toString().split(' ')[2] }}</h2>
              <p><span>{{ new Date(item.created_at).toString().split(' ')[1] }}</span></p>
            </div>
            <div class="col-md-11 explain-text" v-router-link="{ name: 'article', params: { id: item.id } }">
              <div v-if="item.thumb_image !== null " class="col-md-5 margin-top" v-router-link="{ name: 'article-list', params: { id: item.id } }">
                <img :src="item.thumb_image" class="img-responsive" v-show="item.thumb_image" />
              </div>
              <h3>{{ item.title }}</h3>
              <p>{{ (item.keyword).split(',').join(' &nbsp;&nbsp; ') }}</p>
              <p class="margin-top">{{ item.description }}</p>
              <p class="time-author"> <span>{{ item.created_at }}</span><span>作者： {{ item.source_author }}</span></p>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <!--<div class="text-center">-->
      <!--<pagination v-if="refreshPagination" :startPage="currentPage" :url="'http://notadd.ibenchu.win/api/article/fetch'" @change="pageChange"></pagination>-->
    <!--</div>-->
  </div>
</template>
<script>
  import Vue from 'vue'
//  import Pagination from '../components/Pagination'

  export default {
//    components: {
//      Pagination
//    },
    data () {
      return {
        articleList: []
//        refreshPagination: true,
//        currentPage: 1
      }
    },
    mounted () {
      Vue.http.post(window.api + '/content/article/list').then((response) => {
        this.articleList = response.data.data
        this.articleList.forEach(article => {
          article.thumb_image = article.thumb_image ? window.url + '/' + article.thumb_image : ''
        })
        console.log(response)
      }, (response) => {
        console.log(response)
      })
    }
//    methods: {
//      pageChange (data, page) {
//        this.articleList = data
//        this.currentPage = page
//      }
//    }
  }
</script>
