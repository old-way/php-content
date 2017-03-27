<script>
    import sortable from 'html5sortable';
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/page/category/fetch`).then(response => {
                const list = response.data.data;
                next(vm => {
                    vm.list = list;
                    injection.loading.finish();
                    injection.message.info('获取分类列表成功！');
                    injection.sidebar.active('content');
                });
            }).catch(() => {
                injection.loading.fail();
            });
        },
        data() {
            return {
                list: [],
                form: {
                    alias: '',
                    background_color: '',
                    background_image: '',
                    description: '',
                    enabled: '',
                    id: 0,
                    link: '',
                    name: '',
                    pattern: 'create',
                    pagination: 30,
                    seo_title: '',
                    seo_keyword: '',
                    seo_description: '',
                    title: '创建分类',
                    top_image: '',
                },
                loading: false,
                modal: {
                    loading: true,
                    visible: false,
                },
                rules: {
                    alias: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入别名',
                            trigger: 'change',
                        },
                    ],
                    name: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入名称',
                            trigger: 'change',
                        },
                    ],
                },
            };
        },
        methods: {
            create() {
                const self = this;
                self.form.alias = '';
                self.form.background_color = '';
                self.form.background_image = '';
                self.form.description = '';
                self.form.enabled = '1';
                self.form.id = 0;
                self.form.link = '';
                self.form.name = '';
                self.form.pattern = 'create';
                self.form.pagination = 30;
                self.form.seo_title = '';
                self.form.seo_keyword = '';
                self.form.seo_description = '';
                self.form.title = '创建分类';
                self.form.top_image = '';
                self.modal.visible = true;
            },
            edit(item) {
                const self = this;
                self.form.alias = item.alias;
                self.form.background_color = item.background_color;
                self.form.background_image = item.background_image;
                self.form.description = item.description;
                self.form.enabled = item.enabled;
                self.form.id = item.id;
                self.form.link = item.link;
                self.form.name = item.title;
                self.form.pattern = 'edit';
                self.form.pagination = 30;
                self.form.seo_title = item.seo_title;
                self.form.seo_keyword = item.seo_keyword;
                self.form.seo_description = item.seo_description;
                self.form.title = `编辑分类：${item.title}`;
                self.form.top_image = item.top_image;
                self.modal.visible = true;
            },
            remove() {
                const self = this;
                if (self.form.pattern === 'edit') {
                    self.$http.post(`${window.api}/page/category/delete`, self.modal).then(response => {
                        self.list = response.data.data;
                    }).finally(() => {
                        self.modal.visible = false;
                    });
                }
            },
            sorting() {
                const self = this;
                const order = injection.jquery('ul.list-group > li').map((i, first) => ({
                    id: injection.jquery(first).data('id'),
                    children: injection.jquery(first).children('ol').children('li').map((j, second) => ({
                        id: injection.jquery(second).data('id'),
                        children: injection.jquery(second).find('li').map((k, third) => ({
                            id: injection.jquery(third).data('id'),
                        })).get(),
                    }))
                    .get(),
                })).get();
                self.$loading.start();
                self.loading = true;
                self.$http.post(`${window.api}/page/category/sort`, {
                    data: order,
                }).then(response => {
                    self.$nextTick(() => {
                        self.$loading.finish();
                        self.$notice.open({
                            title: '更新排序成功！',
                        });
                        self.list = response.data.data;
                    });
                }).catch(() => {
                    self.$loading.fail();
                }).finally(() => {
                    self.loading = false;
                });
            },
            submit() {
                const self = this;
                self.modal.loading = true;
                if (self.form.pattern === 'create') {
                    self.$http.post(`${window.api}/page/category/create`, self.form).then(response => {
                        self.list = response.data.data;
                        self.$notice.open({
                            title: '创建分类成功！',
                        });
                    }).finally(() => {
                        self.modal.loading = false;
                        self.modal.visible = false;
                    });
                }
                if (self.form.pattern === 'edit') {
                    self.$http.post(`${window.api}/page/category/edit`, self.form).then(response => {
                        self.list = response.data.data;
                        self.$notice.open({
                            title: '编辑分类成功！',
                        });
                    }).finally(() => {
                        self.modal.loading = false;
                        self.modal.visible = false;
                    });
                }
            },
        },
        updated() {
            sortable(injection.jquery(this.$el).find('ul, ol'), {
                connectWith: 'article-category',
            });
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-list">
            <card>
                <template slot="title">
                    <div class="filter">
                        <i-button type="primary" @click.native="create">添加分类</i-button>
                    </div>
                </template>
                <div class="none-item" v-if="list.length === 0">目前还没有分类哦！</div>
                <div class="article-category">
                    <row>
                        <i-col span="16">
                            <ul class="list-group">
                                <li class="list-group-item clear-fix" v-for="item in list" :data-id="item.id">
                                    <div class="list-group-item-content">
                                        <em :style="{ background: item.background_color }"></em>
                                        <span>{{ item.title }}</span>
                                        <i class="handle"></i>
                                        <i-button @click.native="edit(item)" icon="android-create"></i-button>
                                    </div>
                                    <ol class="list-group">
                                        <li class="list-group-item clear-fix" v-for="sub in item.children" :data-id="sub.id">
                                            <div class="list-group-item-content">
                                                <em :style="{ background: sub.background_color }"></em>
                                                <span>{{ sub.title }}</span>
                                                <i class="handle"></i>
                                                <i-button @click.native="edit(sub)" icon="android-create"></i-button>
                                            </div>
                                            <ol class="list-group">
                                                <li class="list-group-item clear-fix" v-for="child in sub.children" :data-id="child.id">
                                                    <div class="list-group-item-content">
                                                        <em :style="{ background: child.background_color }"></em>
                                                        <span>{{ child.title }}</span>
                                                        <i class="handle"></i>
                                                        <i-button @click.native="edit(child)" icon="android-create"></i-button>
                                                    </div>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </li>
                            </ul>
                        </i-col>
                    </row>
                    <row>
                        <i-col>
                            <i-button :loading="loading" type="error" @click.native="sorting">
                                <span v-if="!loading">更新排序</span>
                                <span v-else>正在更新排序…</span>
                            </i-button>
                        </i-col>
                    </row>
                </div>
            </card>
        </div>
        <modal :loading="modal.loading" :value="modal.visible" @on-cancel="modal.visible = false" @on-ok="submit">
            <template slot="header">
                <div class="ivu-modal-header-inner">
                    {{ form.title }}
                    <button v-if="form.pattern === 'edit'" @click="remove">删除</button>
                </div>
            </template>
            <i-form label-position="left" :model="form" ref="form" :rules="rules">
                <form-item label="名称" prop="name">
                    <i-input placeholder="请输入名称" v-model="form.name"></i-input>
                </form-item>
                <form-item label="别名" prop="alias">
                    <i-input placeholder="请输入别名" v-model="form.alias"></i-input>
                </form-item>
                <form-item label="内链" prop="link">
                    <i-input placeholder="请输入内链" v-model="form.link"></i-input>
                </form-item>
                <form-item label="描述" prop="description">
                    <i-input placeholder="请输入描述" v-model="form.description"></i-input>
                </form-item>
                <form-item label="颜色" prop="background">
                    <i-input placeholder="请输入颜色" v-model="form.background_color"></i-input>
                </form-item>
            </i-form>
        </modal>
    </div>
</template>
