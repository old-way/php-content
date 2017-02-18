<template>
  <div class="header-bar">
    <div class="container">
      <div class="header-bar-brand">
        <img src="../assets/images/notadd-logo.png" alt="logo" style="background: transparent">
      </div>
      <div class="header-bar-user">
        <ul class="header-bar-nav">
          <li v-for="item in navigation">
            <router-link :to="item.to">{{ item.text }}</router-link>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    data () {
      return {
        'navigation': [
          {
            'to': { 'name': 'home' },
            'text': '首页'
          },
          {
            'to': { 'name': 'article' },
            'text': '文章'
          },
          {
            'to': { 'name': 'about' },
            'text': '关于'
          }
        ]
      }
    }
  }
</script>
