<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/article/fetch`, {
                trashed: true,
            }).then(response => {
                const list = response.data.data;
                const pagination = response.data.pagination;
                next(vm => {
                    list.forEach(article => {
                        article.loading = false;
                        article.restoring = false;
                    });
                    vm.list = list;
                    vm.pagination = pagination;
                    injection.loading.finish();
                    injection.message.info('获取文章列表成功！');
                    injection.sidebar.active('content');
                });
            }).catch(() => {
                injection.loading.fail();
            });
        },
        data() {
            return {
                columns: [
                    {
                        align: 'center',
                        type: 'selection',
                        width: 60,
                    },
                    {
                        key: 'title',
                        title: '文章名称',
                    },
                    {
                        key: 'author',
                        title: '作者',
                        width: 200,
                    },
                    {
                        key: 'handle',
                        render(row, column, index) {
                            return `
                                    <i-button :loading="list[${index}].restoring" size="small" type="primary" @click.native="restore(${index})">
                                        <span v-if="!list[${index}].restoring">恢复</span>
                                        <span v-else>正在恢复…</span></i-button>
                                    <i-button :loading="list[${index}].loading" size="small" type="error" @click.native="remove(${index})">
                                        <span v-if="!list[${index}].loading">删除</span>
                                        <span v-else>正在删除…</span>
                                    </i-button>
                                    `;
                        },
                        title: '操作',
                        width: 200,
                    },
                ],
                list: [],
                loading: false,
                pagination: {},
                selections: [],
                self: this,
            };
        },
        methods: {
            paginator(id) {
                const self = this;
                self.$loading.start();
                if (self.categories.id === 'none') {
                    self.$http.post(`${window.api}/article/fetch`, {
                        'only-no-category': true,
                        page: id,
                    }).then(response => {
                        const result = response.data;
                        result.data.forEach(item => {
                            item.loading = false;
                            item.restoring = false;
                        });
                        self.list = result.data;
                        self.pagination = result.pagination;
                        self.$loading.finish();
                        self.$message.info('更新文章列表成功！');
                    }).catch(() => {
                        self.$loading.fail();
                    });
                } else {
                    self.$http.post(`${window.api}/article/fetch`, {
                        category: self.categories.id,
                        page: id,
                    }).then(response => {
                        const result = response.data;
                        result.data.forEach(item => {
                            item.loading = false;
                            item.restoring = false;
                        });
                        self.list = result.data;
                        self.pagination = result.pagination;
                        self.$loading.finish();
                        self.$message.info('更新文章列表成功！');
                    }).catch(() => {
                        self.$loading.fail();
                    });
                }
            },
            remove(index) {
                const self = this;
                const article = self.list[index];
                article.loading = true;
                self.$http.post(`${window.api}/article/delete`, {
                    id: article.id,
                    force: true,
                }).then(response => {
                    const result = response.data;
                    result.data.forEach(item => {
                        item.loading = false;
                        item.restoring = false;
                    });
                    self.list = result.data;
                    self.pagination = result.pagination;
                    self.$notice.open({
                        title: `文章[${article.title}]强制删除成功！`,
                    });
                }).finally(() => {
                    article.loading = false;
                });
            },
            removeSelected() {
                const self = this;
                self.$loading.start();
                self.loading = true;
                if (self.selections.length === 0) {
                    self.$loading.finish();
                    self.$notice.error({
                        title: '尚未选择任何文章！',
                    });
                    self.loading = false;
                } else {
                    self.selections.forEach((article, key) => {
                        self.$http.post(`${window.api}/article/delete`, {
                            id: article.id,
                            force: true,
                        }).then(response => {
                            const result = response.data;
                            result.data.forEach(item => {
                                item.loading = false;
                            });
                            self.list = result.data;
                            self.pagination = result.pagination;
                            self.$notice.open({
                                title: `文章[${article.title}]强制删除成功！`,
                            });
                        }).finally(() => {
                            if (self.selections.length === key + 1) {
                                self.$loading.finish();
                                self.loading = false;
                            }
                        });
                    });
                }
            },
            restore(index) {
                const self = this;
                const article = self.list[index];
                article.restoring = true;
                self.$http.post(`${window.api}/article/delete`, {
                    id: article.id,
                    restore: true,
                }).then(response => {
                    const result = response.data;
                    result.data.forEach(item => {
                        item.loading = false;
                        item.restoring = false;
                    });
                    self.list = result.data;
                    self.pagination = result.pagination;
                    self.$notice.open({
                        title: `文章[${article.title}]恢复成功！`,
                    });
                }).finally(() => {
                    article.restoring = false;
                });
            },
            selection(items) {
                this.selections = items;
            },
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-list">
            <card>
                <template slot="title">
                    <div class="filter">
                        <!--<i-select clearable style="width:200px">-->
                            <!--&lt;!&ndash;<i-option v-for="item in cityList" :value="item.value">{{ item.label }}</i-option>&ndash;&gt;-->
                        <!--</i-select>-->
                        <i-button :loading="loading" type="error" @click.native="removeSelected">
                            <span v-if="!loading">删除</span>
                            <span v-else>正在批量删除…</span>
                        </i-button>
                    </div>
                </template>
                <i-table :columns="columns" :content="self" :data="list" @on-selection-change="selection"></i-table>
                <div class="ivu-page-wrap">
                    <page :current="pagination.current_page" :page-size="pagination.per_page" :total="pagination.total" @on-change="paginator"></page>
                </div>
            </card>
        </div>
    </div>
</template>
