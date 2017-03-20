export default function (injection) {
    injection.useSidebar('content', [
        {
            children: [
                {
                    path: '/setting',
                    title: '参数配置',
                },
                {
                    path: '/seo',
                    title: 'SEO设置',
                },
            ],
            icon: 'ios-cog',
            title: '全局设置',
        },
    ]);
}
