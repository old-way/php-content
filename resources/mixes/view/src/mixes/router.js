import Article from '../pages/Article';
import ArticleCategory from '../pages/ArticleCategory';
import ArticleCreate from '../pages/ArticleCreate';
import ArticleDraft from '../pages/ArticleDraft';
import ArticleDraftEdit from '../pages/ArticleDraftEdit';
import ArticleEdit from '../pages/ArticleEdit';
import ArticleRecycle from '../pages/ArticleRecycle';
import Component from '../pages/Component';
import Dashboard from '../pages/Dashboard';
import Layout from '../layouts/Layout';
import Page from '../pages/Page';
import PageCategory from '../pages/PageCategory';
import PageCreate from '../pages/PageCreate';
import PageEdit from '../pages/PageEdit';

export default function (injection) {
    injection.useModuleRoute([
        {
            children: [
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Dashboard,
                    path: '/',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Article,
                    path: 'article',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: ArticleCategory,
                    path: 'article/category',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: ArticleCreate,
                    path: 'article/create',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: ArticleEdit,
                    path: 'article/:id/edit',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: ArticleDraft,
                    path: 'article/draft',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: ArticleDraftEdit,
                    path: 'article/:id/draft',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: ArticleRecycle,
                    path: 'article/recycle',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Component,
                    path: 'component',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Page,
                    path: 'page',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: PageCategory,
                    path: 'page/category',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: PageCreate,
                    path: 'page/create',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: PageEdit,
                    path: 'page/:id/edit',
                },
            ],
            component: Layout,
            path: '/content',
        },
    ]);
}
