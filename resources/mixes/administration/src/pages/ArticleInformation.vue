<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/content/article/information/list`, {
                order: 'asc',
                sort: 'order',
            }).then(response => {
                const data = response.data.data;
                const pagination = response.data.pagination;
                next(vm => {
                    data.forEach(item => {
                        item.loading = false;
                    });
                    vm.list = data;
                    vm.pagination = pagination;
                    injection.loading.finish();
                    injection.sidebar.active('content');
                });
            }).catch(() => {
                injection.loading.error();
            });
        },
        data() {
            const self = this;
            return {
                columns: [
                    {
                        key: 'name',
                        title: '信息项名称',
                        width: 300,
                    },
                    {
                        align: 'center',
                        key: 'order',
                        render(h, data) {
                            const row = data.row;
                            return h('i-input', {
                                on: {
                                    'on-change': event => {
                                        row.order = event.target.value;
                                    },
                                    'on-blur': () => {
                                        self.update(row);
                                    },
                                },
                                props: {
                                    value: self.list[data.index].order,
                                },
                            });
                        },
                        title: '显示顺序',
                        width: 120,
                    },
                    {
                        align: 'center',
                        key: 'required',
                        render(h, data) {
                            return h('checkbox', {
                                on: {
                                    input(value) {
                                        data.row.required = value;
                                        self.update(data.row);
                                    },
                                },
                                props: {
                                    value: self.list[data.index].required,
                                },
                            });
                        },
                        title: '是否必填',
                        width: 120,
                    },
                    {
                        key: 'none',
                        title: ' ',
                    },
                    {
                        key: 'handle',
                        render(h, data) {
                            let text;
                            if (self.list[data.index].loading) {
                                text = injection.trans('content.global.delete.loading');
                            } else {
                                text = injection.trans('content.global.delete.submit');
                            }
                            return h('div', [
                                h('router-link', {
                                    props: {
                                        to: `/content/article/information/${data.row.id}/edit`,
                                    },
                                }, [
                                    h('i-button', {
                                        props: {
                                            size: 'small',
                                            type: 'default',
                                        },
                                    }, '编辑'),
                                ]),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.remove(data.index);
                                        },
                                    },
                                    props: {
                                        size: 'small',
                                        type: 'error',
                                    },
                                    style: {
                                        marginLeft: '10px',
                                    },
                                }, [
                                    h('span', text),
                                ]),
                            ]);
                        },
                        title: '操作',
                        width: 300,
                    },
                ],
                list: [],
                pagination: {},
                self: this,
            };
        },
        methods: {
            remove(index) {
                const self = this;
                const information = self.list[index];
                information.loading = true;
                self.$http.post(`${window.api}/content/article/information/remove`, {
                    id: information.id,
                }).then(() => {
                    self.$notice.open({
                        title: '删除信息项成功！',
                    });
                    self.refresh();
                }).catch(() => {
                    self.$notice.error({
                        title: '删除信息项失败！',
                    });
                }).finally(() => {
                    information.loading = false;
                });
            },
            refresh() {
                const self = this;
                self.$notice.open({
                    title: '正在刷新数据...',
                });
                self.$loading.start();
                self.$http.post(`${window.api}/content/article/information/list`, {
                    order: 'asc',
                    sort: 'order',
                }).then(response => {
                    const data = response.data.data;
                    const pagination = response.data.pagination;
                    data.forEach(item => {
                        item.loading = false;
                    });
                    self.$loading.finish();
                    self.$notice.open({
                        title: '刷新数据完成！',
                    });
                    self.list = data;
                    self.pagination = pagination;
                }).catch(() => {
                    self.$loading.error();
                });
            },
            update(data) {
                const self = this;
                self.$notice.open({
                    title: '更新信息项',
                });
                self.$loading.start();
                self.$http.post(`${window.api}/content/article/information/edit`, data).then(() => {
                    self.$loading.finish();
                    self.$notice.open({
                        title: '更新信息项数据成功！',
                    });
                    self.refresh();
                }).catch(() => {
                    self.$loading.fail();
                    self.$notice.error({
                        title: '更新信息项数据失败！',
                    });
                });
            },
        },
    };
</script>
<template>
    <div class="member-wrap">
        <div class="user-information">
            <card :bordered="false">
                <template slot="title">
                    <span class="text">信息列表</span>
                    <router-link class="extend" to="/content/article/information/create">
                        <i-button type="default">添加信息项</i-button>
                    </router-link>
                </template>
                <i-table :columns="columns" :context="self" :data="list"></i-table>
                <div class="ivu-page-wrap">
                    <page :current="pagination.current"
                          :page-size="pagination.paginate"
                          :total="pagination.total"
                          @on-change="paginator"></page>
                </div>
            </card>
        </div>
    </div>
</template>