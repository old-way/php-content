export default {
  header: function (menu) {
    menu.push({
      'text': '文章',
      'icon': 'icon icon-article',
      'uri': '/content'
    })
  },
  router: function (bases, modules, requireAuth) {
  }
}
