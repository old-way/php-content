<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.all([
                injection.http.post(`${window.api}/page/fetch`),
                injection.http.post(`${window.api}/page/category/fetch`, {
                    'with-children': true,
                }),
            ]).then(injection.http.spread((pageData, categoryData) => {
                window.console.log(pageData, categoryData);
                const list = pageData.data.data;
                const pagination = pageData.data.pagination;
                next(vm => {
                    list.forEach(page => {
                        page.loading = false;
                    });
                    vm.list = list;
                    vm.pagination = pagination;
                    vm.categories.all = categoryData.data.data;
                    vm.categories.all.forEach(category => {
                        if (category.parent_id === 0) {
                            vm.categories.first.push(category);
                        }
                    });
                    injection.loading.finish();
                    injection.message.info('获取页面列表成功！');
                    injection.sidebar.active('content');
                });
            })).catch(() => {
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
                        title: '页面名称',
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
                                    <i-button size="small" type="primary" @click.native="edit(${index})">编辑</i-button>
                                    <i-button :loading="list[${index}].loading"  size="small" type="error" @click.native="remove(${index})">
                                        <span v-if="!list[${index}].loading">删除</span>
                                        <span v-else>正在删除…</span>
                                    </i-button>
                                    `;
                        },
                        title: '操作',
                        width: 200,
                    },
                ],
                keyword: '',
                list: [],
                loading: false,
                pagination: {},
                selections: [],
                self: this,
            };
        },
        methods: {
            edit(index) {
                const self = this;
                const article = self.list[index];
                self.$router.push(`/content/page/${article.id}/edit`);
            },
            paginator(id) {
                const self = this;
                self.$loading.start();
                if (self.categories.id === 'none') {
                    self.$http.post(`${window.api}/page/fetch`, {
                        'only-no-category': true,
                        page: id,
                    }).then(response => {
                        const result = response.data;
                        result.data.forEach(item => {
                            item.loading = false;
                        });
                        self.list = result.data;
                        self.pagination = result.pagination;
                        self.$loading.finish();
                        self.$message.info('更新页面列表成功！');
                    }).catch(() => {
                        self.$loading.fail();
                    });
                } else {
                    self.$http.post(`${window.api}/page/fetch`, {
                        category: self.categories.id,
                        page: id,
                    }).then(response => {
                        const result = response.data;
                        result.data.forEach(item => {
                            item.loading = false;
                        });
                        self.list = result.data;
                        self.pagination = result.pagination;
                        self.$loading.finish();
                        self.$message.info('更新页面列表成功！');
                    }).catch(() => {
                        self.$loading.fail();
                    });
                }
            },
            remove(index) {
                const self = this;
                const article = self.list[index];
                article.loading = true;
                self.$http.post(`${window.api}/page/delete`, {
                    id: article.id,
                }).then(response => {
                    const result = response.data;
                    result.data.forEach(item => {
                        item.loading = false;
                    });
                    self.list = result.data;
                    self.pagination = result.pagination;
                    self.$message.info('删除页面成功！');
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
                        title: '尚未选择任何页面！',
                    });
                    self.loading = false;
                } else {
                    self.selections.forEach((article, key) => {
                        self.$http.post(`${window.api}/page/delete`, {
                            id: article.id,
                        }).then(response => {
                            const result = response.data;
                            result.data.forEach(page => {
                                page.loading = false;
                            });
                            self.list = result.data;
                            self.pagination = result.pagination;
                            self.$notice.open({
                                title: `页面[${article.title}]删除成功！`,
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
            search() {
                const self = this;
                if (self.keyword.length > 0) {
                    injection.loading.start();
                    self.$http.post(`${window.api}/page/fetch`, {
                        search: self.keyword,
                    }).then(response => {
                        const list = response.data.data;
                        list.forEach(page => {
                            page.loading = false;
                        });
                        self.list = list;
                        self.pagination = response.data.pagination;
                        injection.loading.finish();
                        injection.message.info('获取文章列表成功！');
                        injection.sidebar.active('content');
                    }).catch(() => {
                        injection.loading.fail();
                    });
                } else {
                    self.$notice.error({
                        title: '请先输入搜索关键词！',
                    });
                }
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
                    <i-input class="search" placeholder="请输入搜索关键字" v-model="keyword">
                        <i-button slot="append" icon="ios-search" @click.native="search"></i-button>
                    </i-input>
                    <div class="filter">
                        <i-select clearable style="width:200px">
                            <!--<i-option v-for="item in cityList" :value="item.value">{{ item.label }}</i-option>-->
                        </i-select>
                        <router-link to="/content/page/create">
                            <i-button type="primary">添加页面</i-button>
                        </router-link>
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
