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
}
