export default function (injection) {
    injection.useBoard({
        content: {
            title: {
                text: 'Notadd Content 模块图标测试',
            },
            tooltip: {},
            xAxis: {
                data: ['资讯', '科技', '文化', '讲座', '娱乐', '软件'],
            },
            yAxis: {},
            series: [
                {
                    name: 'Sales',
                    type: 'bar',
                    data: [5, 20, 36, 10, 10, 20],
                },
            ],
        },
        span: 12,
        style: 'height: 300px;',
        title: '这是 Chart 标题',
        type: 'chart',
    });
}