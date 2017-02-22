import Vue from 'vue'
import VueResource from 'vue-resource'
import App from './App'
import router from './router'
import jQuery from 'jquery'
import AMap from 'vue-amap'

import './assets/less/bootstrap-notadd.less'
import RouterLink from './directives/router-link'

Vue.use(VueResource)
Vue.use(AMap)

global.window.jQuery = jQuery
require('bootstrap')

Vue.directive('router-link', RouterLink)

/* eslint-disable no-new */
// 初始化vue-amap
AMap.initAMapApiLoader({
  // 高德的key
  key: '6e6fc311a319cf1e090a604b6ad7ff99',
  // 插件集合
  plugin: ['AMap.Autocomplete', 'AMap.PlaceSearch', 'AMap.Scale', 'AMap.OverView', 'AMap.ToolBar', 'AMap.MapType', 'AMap.PolyEditor', 'AMap.CircleEditor']
})
new Vue({
  el: '#app',
  router,
  render: h => h(App),
  template: '<App/>',
  components: { App }
})

