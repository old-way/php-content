import ContentArticle from '../components/Article'
import ContentArticleCreate from '../components/ArticleCreate'
import ContentArticleDraft from '../components/ArticleDraft'
import ContentArticleDraftEdit from '../components/ArticleDraftEdit'
import ContentArticleEdit from '../components/ArticleEdit'
import ContentArticleRecycle from '../components/ArticleRecycle'
import ContentCategory from '../components/ArticleCategory'
import ContentCategoryUpdated from '../components/ArticleCategoryUpdated'
import ContentComment from '../components/Comment'
import ContentComponent from '../components/Component'
import ContentDashboard from '../components/Dashboard'
import ContentLayout from '../components/Layout'
import ContentPage from '../components/Page'
import ContentPageCategory from '../components/PageCategory'
import ContentPageCategoryUpdated from '../components/PageCategoryUpdated'
import ContentPageCreate from '../components/PageCreate'
import ContentPageEdit from '../components/PageEdit'
import ContentTemplate from '../components/Template'
import ContentTag from '../components/ArticleTag'
export function headerMixin (Core) {
  Core.header = function (menu) {
    menu.push({
      'text': '文章',
      'icon': 'icon icon-article',
      'uri': '/content'
    })
  }
}
export function installMixin (Core) {
  Core.install = function (Vue, Notadd) {
    Core.instance = Notadd
    vueMixin(Core, Vue)
  }
}
export function routerMixin (Core) {
  Core.router = function (router) {
    router.modules.push({
      path: '/content',
      component: ContentLayout,
      children: [
        {
          path: '/',
          component: ContentDashboard,
          beforeEnter: router.auth
        },
        {
          path: 'article/all',
          component: ContentArticle,
          beforeEnter: router.auth
        },
        {
          path: 'article/create',
          component: ContentArticleCreate,
          beforeEnter: router.auth
        },
        {
          path: 'article/:id/draft',
          component: ContentArticleDraftEdit,
          beforeEnter: router.auth
        },
        {
          path: 'article/:id/edit',
          component: ContentArticleEdit,
          beforeEnter: router.auth
        },
        {
          path: 'article/category',
          component: ContentCategory,
          beforeEnter: router.auth
        },
        {
          path: 'article/category/updated',
          component: ContentCategoryUpdated,
          beforeEnter: router.auth
        },
        {
          path: 'article/tag',
          component: ContentTag,
          beforeEnter: router.auth
        },
        {
          path: 'article/recycle',
          component: ContentArticleRecycle,
          beforeEnter: router.auth
        },
        {
          path: 'article/draft',
          component: ContentArticleDraft,
          beforeEnter: router.auth
        },
        {
          path: 'page/all',
          component: ContentPage,
          beforeEnter: router.auth
        },
        {
          path: 'page/create',
          component: ContentPageCreate,
          beforeEnter: router.auth
        },
        {
          path: 'page/:id/edit',
          component: ContentPageEdit,
          beforeEnter: router.auth
        },
        {
          path: 'page/category',
          component: ContentPageCategory,
          beforeEnter: router.auth
        },
        {
          path: 'page/category/updated',
          component: ContentPageCategoryUpdated,
          beforeEnter: router.auth
        },
        {
          path: 'component',
          component: ContentComponent,
          beforeEnter: router.auth
        },
        {
          path: 'template',
          component: ContentTemplate,
          beforeEnter: router.auth
        },
        {
          path: 'comment',
          component: ContentComment,
          beforeEnter: router.auth
        }
      ]
    })
  }
}
export function vueMixin (Core, Vue) {
  Core.http = Vue.http
}