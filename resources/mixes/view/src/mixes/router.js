export default function (injection) {
    instance.useModuleRoute([
        {
            path: 'content',
            children: [
                {
                    path: 'article',
                },
            ],
        },
    ]);
}
