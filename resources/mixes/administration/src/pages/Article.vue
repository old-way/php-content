<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.all([
                injection.http.post(`${window.api}/article/fetch`),
                injection.http.post(`${window.api}/category/fetch`, {
                    'with-children': true,
                }),
            ]).then(injection.http.spread((articleData, categoryData) => {
                const list = articleData.data.data;
                const pagination = articleData.data.pagination;
                next(vm => {
                    list.forEach(article => {
                        article.loading = false;
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
                    injection.message.info('获取文章列表成功！');
                    injection.sidebar.active('content');
                });
            })).catch(() => {
                injection.loading.fail();
            });
        },
        data() {
            return {
                categories: {
                    all: [],
                    first: [],
                    id: 0,
                    none: false,
                    selected: {
                        first: 0,
                        second: 0,
                        third: 0,
                    },
                    second: [],
                    third: [],
                },
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
                        key: 'created_at',
                        title: '发布时间',
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
            category(value, level) {
                const self = this;
                function find() {
                    let selected;
                    self.categories.all.forEach(cateogry => {
                        if (cateogry.id.toString() === self.categories.id.toString()) {
                            selected = cateogry;
                        }
                    });
                    return selected;
                }
                let category;
                self.categories.id = value;
                if (self.categories.id === '0') {
                    switch (level) {
                        case 'first':
                            self.categories.second = [];
                            self.categories.third = [];
                            break;
                        case 'second':
                            self.categories.third = [];
                            self.categories.id = self.categories.selected.first;
                            break;
                        case 'third':
                            self.categories.id = self.categories.selected.second;
                            break;
                        default:
                            break;
                    }
                } else {
                    switch (level) {
                        case 'first':
                            if (self.categories.id === 'none') {
                                self.categories.second = [];
                                self.categories.third = [];
                            } else {
                                category = find();
                                self.categories.second = category.children ? category.children : [];
                                self.categories.third = [];
                                self.categories.selected.first = self.categories.id;
                            }
                            break;
                        case 'second':
                            category = find();
                            self.categories.third = category.children ? category.children : [];
                            self.categories.selected.second = self.categories.id;
                            break;
                        case 'third':
                            self.categories.selected.third = self.categories.id;
                            break;
                        default:
                            break;
                    }
                }
                if (self.categories.id === 'none') {
                    self.$http.post(`${window.api}/article/fetch`, {
                        'only-no-category': true,
                    }).then(response => {
                        self.list = [];
                        response.data.data.forEach(article => {
                            article.checked = false;
                            self.list.push(article);
                        });
                        self.pagination = response.data.pagination;
                    });
                } else {
                    self.$http.post(`${window.api}/article/fetch`, {
                        category: self.categories.id,
                    }).then(response => {
                        self.list = [];
                        response.data.data.forEach(article => {
                            article.checked = false;
                            self.list.push(article);
                        });
                        self.pagination = response.data.pagination;
                    });
                }
            },
            edit(index) {
                const self = this;
                const article = self.list[index];
                self.$router.push(`/content/article/${article.id}/edit`);
            },
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
                }).then(response => {
                    const result = response.data;
                    result.data.forEach(item => {
                        item.loading = false;
                    });
                    self.list = result.data;
                    self.pagination = result.pagination;
                    self.$message.info('删除文章成功！');
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
                        }).then(response => {
                            const result = response.data;
                            result.data.forEach(item => {
                                item.loading = false;
                            });
                            self.list = result.data;
                            self.pagination = result.pagination;
                            self.$notice.open({
                                title: `删除文章[${article.title}]成功！`,
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
                    injection.http.post(`${window.api}/article/fetch`, {
                        search: self.keyword,
                    }).then(response => {
                        const list = response.data.data;
                        list.forEach(article => {
                            article.loading = false;
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
        watch: {
            'categories.selected.first': {
                deep: true,
                handler(value) {
                    this.category(value, 'first');
                },
            },
            'categories.selected.second': {
                deep: true,
                handler(value) {
                    this.category(value, 'second');
                },
            },
            'categories.selected.third': {
                deep: true,
                handler(value) {
                    this.category(value, 'third');
                },
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
                        <i-select clearable style="width:200px" v-if="categories.first.length !== 0" v-model="categories.selected.first">
                            <i-option value="none">未分类</i-option>
                            <i-option v-for="category in categories.first" :value="category.id">{{ category.title }}</i-option>
                        </i-select>
                        <i-select clearable style="width:200px" v-if="categories.second.length !== 0" v-model="categories.selected.second">
                            <i-option value="none">未分类</i-option>
                            <i-option v-for="category in categories.second" :value="category.id">{{ category.title }}</i-option>
                        </i-select>
                        <i-select clearable style="width:200px" v-if="categories.third.length !== 0" v-model="categories.selected.third">
                            <i-option value="none">未分类</i-option>
                            <i-option v-for="category in categories.third" :value="category.id">{{ category.title }}</i-option>
                        </i-select>
                        <router-link to="/content/article/create">
                            <i-button type="primary">添加文章</i-button>
                        </router-link>
                        <i-button :loading="loading" type="error" @click.native="removeSelected">
                            <span v-if="!loading">删除</span>
                            <span v-else>正在批量删除…</span>
                        </i-button>
                    </div>
                </template>
                <i-table :columns="columns" :content="self" :data="list" @on-selection-change="selection"></i-table>
                <div class="ivu-page-wrap">
                    <page :current="pagination.current_page" :page-size="pagination.per_page" :total="pagination.total"
                          @on-change="paginator"></page>
                </div>
            </card>
        </div>
    </div>
</template>
