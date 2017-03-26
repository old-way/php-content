<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/article/fetch`).then(response => {
                const list = response.data.data;
                const pagination = response.data.pagination;
                next(vm => {
                    injection.loading.finish();
                    injection.sidebar.active('content');
                    vm.list = list;
                    vm.pagination = pagination;
                    window.console.log(pagination);
                });
            }).catch(() => {
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
                        key: 'author',
                        title: '作者',
                        width: 200,
                    },
                    {
                        key: 'handle',
                        render(row, column, index) {
                            return `
                                    <i-button type="primary" @click.native="edit(${index})">编辑</i-button>
                                    <i-button type="error" @click.native="remove(${index})">删除</i-button>
                                    `;
                        },
                        title: '操作',
                        width: 200,
                    },
                ],
                list: [],
                pagination: {},
                self: this,
            };
        },
        methods: {
            edit(index) {
                console.log(index);
            },
            paginator(id) {
                const self = this;
                self.$loading.start();
                if (self.categories.id === 'none') {
                    self.$http.post(`${window.api}/article/fetch`, {
                        'only-no-category': true,
                        page: id,
                    }).then(response => {
                        self.list = response.data.data;
                        self.pagination = response.data.pagination;
                        self.$loading.finish();
                    }).catch(() => {
                        self.$loading.fail();
                    });
                } else {
                    self.$http.post(`${window.api}/article/fetch`, {
                        category: self.categories.id,
                        page: id,
                    }).then(response => {
                        self.list = response.data.data;
                        self.pagination = response.data.pagination;
                        self.$loading.finish();
                    }).catch(() => {
                        self.$loading.fail();
                    });
                }
            },
            remove(index) {
                console.log(index);
            },
        },
        watch: {
            pagination(val) {
                window.console.log(val);
            },
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-list">
            <card>
                <template slot="title">
                    <i-input class="search" placeholder="请输入搜索关键字">
                        <i-button slot="append" icon="ios-search"></i-button>
                    </i-input>
                    <div class="filter">
                        <i-select clearable style="width:200px">
                            <!--<i-option v-for="item in cityList" :value="item.value">{{ item.label }}</i-option>-->
                        </i-select>
                        <router-link to="/content/article/create">
                            <i-button type="primary">添加文章</i-button>
                        </router-link>
                        <i-button type="error">删除</i-button>
                    </div>
                </template>
                <i-table :columns="columns" :content="self" :data="list"></i-table>
                <div class="ivu-page-wrap">
                    <page :current="pagination.current_page" :page-size="pagination.per_page" :total="pagination.total" @on-change="paginator"></page>
                </div>
            </card>
        </div>
    </div>
</template>
