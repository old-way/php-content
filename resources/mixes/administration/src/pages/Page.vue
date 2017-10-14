<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.all([
                injection.http.post(`${window.api}/content/page/list`),
                injection.http.post(`${window.api}/content/page/category/list`, {
                    'with-children': true,
                }),
            ]).then(injection.http.spread((pageData, categoryData) => {
                window.console.log(pageData, categoryData);
                const list = pageData.data.data;
                const { pagination } = pageData.data;
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
                    injection.message.info(injection.trans('content.page.list.info.get'));
                });
            })).catch(() => {
                injection.loading.fail();
            });
        },
        data() {
            const self = this;
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
                        title: injection.trans('content.page.list.table.title'),
                    },
                    {
                        key: 'author',
                        title: injection.trans('content.page.list.table.author'),
                        width: 200,
                    },
                    {
                        key: 'handle',
                        render(h, data) {
                            let text = '';
                            if (self.list[data.index].loading) {
                                text = injection.trans('content.global.delete.loading');
                            } else {
                                text = injection.trans('content.global.delete.submit');
                            }
                            return h('div', [
                                h('router-link', {
                                    props: {
                                        to: `/content/page/${data.row.id}/edit`,
                                    },
                                }, [
                                    h('i-button', {
                                        props: {
                                            size: 'small',
                                            type: 'primary',
                                        },
                                    }, injection.trans('content.global.edit.submit')),
                                ]),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.remove(data.index);
                                        },
                                    },
                                    props: {
                                        loading: self.list[data.index].loading,
                                        size: 'small',
                                        type: 'error',
                                    },
                                }, [
                                    h('span', text),
                                ]),
                            ]);
                        },
                        title: injection.trans('content.page.list.table.handle'),
                        width: 200,
                    },
                ],
                keyword: '',
                list: [],
                loading: false,
                pagination: {},
                selections: [],
                self: this,
                trans: injection.trans,
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
                    self.$http.post(`${window.api}/content/page/list`, {
                        'only-no-category': true,
                    }).then(response => {
                        self.list = [];
                        response.data.data.forEach(page => {
                            page.checked = false;
                            self.list.push(page);
                        });
                        self.pagination = response.data.pagination;
                    });
                } else {
                    self.$http.post(`${window.api}/content/page/list`, {
                        category: self.categories.id,
                    }).then(response => {
                        self.list = [];
                        response.data.data.forEach(page => {
                            page.checked = false;
                            self.list.push(page);
                        });
                        self.pagination = response.data.pagination;
                    });
                }
            },
            paginator(id) {
                const self = this;
                self.$loading.start();
                if (self.categories.id === 'none') {
                    self.$http.post(`${window.api}/content/page/list`, {
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
                        self.$message.info(injection.trans('content.page.list.info.update'));
                    }).catch(() => {
                        self.$loading.fail();
                    });
                } else {
                    self.$http.post(`${window.api}/content/page/list`, {
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
                        self.$message.info(injection.trans('content.page.list.info.update'));
                    }).catch(() => {
                        self.$loading.fail();
                    });
                }
            },
            remove(index) {
                const self = this;
                const page = self.list[index];
                page.loading = true;
                self.$http.post(`${window.api}/content/page/remove`, {
                    id: page.id,
                }).then(response => {
                    const result = response.data;
                    result.data.forEach(item => {
                        item.loading = false;
                    });
                    self.list = result.data;
                    self.pagination = result.pagination;
                    self.$message.info(injection.trans('content.page.info.update'));
                }).finally(() => {
                    page.loading = false;
                });
            },
            removeSelected() {
                const self = this;
                self.$loading.start();
                self.loading = true;
                if (self.selections.length === 0) {
                    self.$loading.finish();
                    self.$notice.error({
                        title: injection.trans('content.page.list.info.none'),
                    });
                    self.loading = false;
                } else {
                    self.selections.forEach((page, key) => {
                        self.$http.post(`${window.api}/content/page/remove`, {
                            id: page.id,
                        }).then(response => {
                            const result = response.data;
                            result.data.forEach(item => {
                                item.loading = false;
                            });
                            self.list = result.data;
                            self.pagination = result.pagination;
                            self.$notice.open({
                                title: injection.trans('content.page.info.delete'),
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
                    self.$loading.start();
                    self.$http.post(`${window.api}/content/page/list`, {
                        search: self.keyword,
                    }).then(response => {
                        const list = response.data.data;
                        list.forEach(page => {
                            page.loading = false;
                        });
                        self.list = list;
                        self.pagination = response.data.pagination;
                        self.$loading.finish();
                        self.$message.info(injection.trans('content.page.list.info.get'));
                    }).catch(() => {
                        self.$loading.fail();
                    });
                } else {
                    self.$notice.error({
                        title: injection.trans('content.global.search.error'),
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
            <card :bordered="false">
                <template slot="title">
                    <i-input class="search" :placeholder="trans('content.global.search.placeholder')" v-model="keyword">
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
                        <router-link to="/content/page/create">
                            <i-button type="primary">{{ trans('content.page.info.create') }}</i-button>
                        </router-link>
                        <i-button :loading="loading" type="error" @click.native="removeSelected">
                            <span v-if="!loading">{{ trans('content.global.delete.submit') }}</span>
                            <span v-else>{{ trans('content.global.delete.batch.loading') }}</span>
                        </i-button>
                    </div>
                </template>
                <i-table :columns="columns" :context="self" :data="list" @on-selection-change="selection"></i-table>
                <div class="ivu-page-wrap">
                    <page :current="pagination.current_page" :page-size="pagination.per_page" :total="pagination.total" @on-change="paginator"></page>
                </div>
            </card>
        </div>
    </div>
</template>