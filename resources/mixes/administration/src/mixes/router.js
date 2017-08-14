import Article from '../pages/Article.vue';
import ArticleCategory from '../pages/ArticleCategory.vue';
import ArticleCreate from '../pages/ArticleCreate.vue';
import ArticleDraft from '../pages/ArticleDraft.vue';
import ArticleDraftEdit from '../pages/ArticleDraftEdit.vue';
import ArticleEdit from '../pages/ArticleEdit.vue';
import ArticleInformation from '../pages/ArticleInformation.vue';
import ArticleInformationCreate from '../pages/ArticleInformationCreate.vue';
import ArticleInformationEdit from '../pages/ArticleInformationEdit.vue';
import ArticleRecycle from '../pages/ArticleRecycle.vue';
import Component from '../pages/Component.vue';
import Dashboard from '../pages/Dashboard.vue';
import Layout from '../layouts/Layout.vue';
import Page from '../pages/Page.vue';
import PageCategory from '../pages/PageCategory.vue';
import PageCreate from '../pages/PageCreate.vue';
import PageEdit from '../pages/PageEdit.vue';

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
                    component: ArticleInformation,
                    path: 'article/information',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: ArticleInformationCreate,
                    path: 'article/information/create',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: ArticleInformationEdit,
                    path: 'article/information/:id/edit',
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