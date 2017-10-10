import Layout from '../components/Layout'
import Home from '../components/Home'
import About from '../components/About'
import Article from '../components/Article'
import ArticleList from '../components/ArticleList'

export default [
  {
    path: '/content',
    component: Layout,
    children: [
      {
        path: '/content',
        name: 'home',
        component: Home
      },
      {
        path: 'about',
        name: 'about',
        component: About
      },
      {
        path: 'article',
        name: 'article-list',
        component: Article
      },
      {
        path: 'article/:id',
        name: 'article',
        component: ArticleList
      }
    ]
  }
]
