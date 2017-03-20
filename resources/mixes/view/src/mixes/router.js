export default function (injection) {
    injection.useModuleRoute([
        {
            path: 'content',
            children: [
                {
                    path: 'article',
                },
            ],
        },
    ]);

    injection.useNavigation({
        icon: 'ios-book',
        path: '/content',
        title: 'CMS',
    });
}
