import Layout from '../components/Layout'
import Home from '../components/Home'
import About from '../components/About'
import Article from '../components/Article'
import ArticleList from '../components/ArticleList'

export default [
  {
    path: '/',
    component: Layout,
    children: [
      {
        name: '',
        path: '',
        redirect: { name: 'home' }
      },
      {
        path: 'home',
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
        name: 'article',
        component: Article
      },
      {
        path: 'article/:id',
        name: 'article-list',
        component: ArticleList
      }
    ]
  }
]
