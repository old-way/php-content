import Dashboard from '../pages/Dashboard';

export default function (injection) {
    injection.useModuleRoute([
        {
            path: 'content',
            children: [
                {
                    component: Dashboard,
                    path: '/',
                },
            ],
        },
    ]);
}
