export default function (injection) {
    injection.useSidebar('content', [
        {
            children: [
                {
                    path: '/content/article',
                    title: '全部文章',
                },
                // {
                //     path: '/content/article/category',
                //     title: '分类管理',
                // },
                {
                    path: '/content/article/recycle',
                    title: '回收站',
                },
                // {
                //     path: '/content/article/draft',
                //     title: '草稿箱',
                // },
            ],
            icon: 'plus',
            title: '文章管理',
        },
        {
            children: [
                {
                    path: '/content/page',
                    title: '全部页面',
                },
                // {
                //     path: '/content/page/category',
                //     title: '分类管理',
                // },
            ],
            icon: 'plus',
            title: '页面管理',
        },
        {
            children: [
                {
                    path: '/content/component',
                    title: 'SEO 配置',
                },
            ],
            icon: 'plus',
            title: '模块管理',
        },
    ]);
}
