<template>
  <div class="article_list">
    <div class="top-title">
      <h1>Business For Future</h1>
      <p>Lorem ipsun dolor sit amet, feugiat delicata liberseid cumis.</p>
    </div>
    <div class="container main">
      <div class="row margin-top border-btm">
        <div class="col-md-1 text-center date">
          <h2>{{ new Date(created_at).toString().split(' ')[2] }}</h2>
          <p><span>{{ new Date(created_at).toString().split(' ')[1] }}</span></p>
        </div>
        <div class="col-md-11 margin-top">
          <img :src=" 'http://notadd.ibenchu.win/' + thumb_image" class="img-responsive" v-if=" thumb_image !== null "/>
          <h3>{{ title }}</h3>
          <p>{{ keyword.split(',').join(' &nbsp;&nbsp; ') }}</p>
          <div v-html="content" class="article-content"></div>
          <p class="time-author"> <span>{{ created_at }}</span><span>作者： {{ source_author }}</span></p>
        </div>
      </div>
      <div class="row view">
        <h4>想要对我们说点什么？</h4>
        <form role="form">
          <div class="col-md-4">
            <div class="form-group">
              <label class="sr-only" for="name">名称</label>
              <input type="text" class="form-control" id="name" placeholder="名字">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="sr-only" for="emall">邮箱</label>
              <input type="email" class="form-control" id="emall" placeholder="电子邮箱">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="sr-only" for="weibo">微博</label>
              <input type="email" class="form-control" id="weibo" placeholder="微博">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="sr-only" for="chat">想说的话</label>
              <textarea class="form-control" rows="10" id="chat" placeholder="想说的话"> </textarea>
            </div>
          </div>
          <div class="col-md-4 col-md-offset-8">
            <div class="form-group">
              <button type="submit" class="btn btn-view">保存</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
  import Vue from 'vue'

  export default {
    data () {
      return {
        title: '',
        content: '',
        thumb_image: '',
        created_at: '',
        keyword: '',
        source_author: ''
      }
    },
    beforeRouteEnter (to, from, next) {
      Vue.http.post('http://notadd.ibenchu.win/api/article/find', {
        id: to.params.id
      }).then((response) => {
        const data = response.data.data
        const id = data.id
        const title = data.title
        const content = data.content
        const thumbImage = data.thumb_image
        const createdAt = data.created_at
        const keyword = data.keyword
        const sourseAuthor = data.source_author

        next((vm) => {
          vm.id = id
          vm.thumb_image = thumbImage
          vm.content = content
          vm.title = title
          vm.created_at = createdAt
          vm.keyword = keyword
          vm.source_author = sourseAuthor
        })
      }, (response) => {
        console.log(response)
        next(false)
      })
    }
  }
</script>
