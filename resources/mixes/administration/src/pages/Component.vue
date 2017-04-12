<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/content/component/get`).then(response => {
                const data = response.data.data;
                next(vm => {
                    injection.loading.finish();
                    injection.sidebar.active('content');
                    window.console.log(data);
                    vm.form.article.description = data.articleDescription;
                    vm.form.article.keyword = data.articleKeyword;
                    vm.form.article.title = data.articleTitle;
                    vm.form.category.description = data.categoryDescription;
                    vm.form.category.keyword = data.categoryKeyword;
                    vm.form.category.title = data.categoryTitle;
                    vm.form.page.description = data.pageDescription;
                    vm.form.page.keyword = data.pageKeyword;
                    vm.form.page.title = data.pageTitle;
                });
            });
        },
        data() {
            return {
                form: {
                    article: {
                        description: '',
                        keyword: '',
                        title: '',
                    },
                    category: {
                        description: '',
                        keyword: '',
                        title: '',
                    },
                    page: {
                        description: '',
                        keyword: '',
                        title: '',
                    },
                },
                loading: false,
                trans: injection.trans,
            };
        },
        methods: {
            submit() {
                const self = this;
                self.loading = true;
                self.$http.post(`${window.api}/content/component/set`, self.form).then(() => {
                    self.$notice.open({
                        title: '更新 SEO 设置信息成功！',
                    });
                }).finally(() => {
                    self.loading = false;
                });
            },
        },
    };
</script>
<template>
    <i-form :label-width="200" :model="form" ref="form">
        <card>
            <p slot="title">文章 SEO 配置</p>
            <row>
                <i-col span="14">
                    <form-item label="标题">
                        <i-input placeholder="请输入标题" v-model="form.article.title" :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="14">
                    <form-item label="描述">
                        <i-input type="textarea" placeholder="请输入描述" v-model="form.article.keyword"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="14">
                    <form-item label="关键字">
                        <i-input type="textarea" placeholder="请输入关键字" v-model="form.article.description"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
        </card>
        <card>
            <p slot="title">文章 SEO 配置</p>
            <row>
                <i-col span="14">
                    <form-item label="标题">
                        <i-input placeholder="请输入标题" v-model="form.category.title" :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="14">
                    <form-item label="描述">
                        <i-input type="textarea" placeholder="请输入描述" v-model="form.category.keyword"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="14">
                    <form-item label="关键字">
                        <i-input type="textarea" placeholder="请输入关键字" v-model="form.category.description"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
        </card>
        <card>
            <p slot="title">文章 SEO 配置</p>
            <row>
                <i-col span="14">
                    <form-item label="标题">
                        <i-input placeholder="请输入标题" v-model="form.page.title" :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="14">
                    <form-item label="描述">
                        <i-input type="textarea" placeholder="请输入描述" v-model="form.page.keyword"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="14">
                    <form-item label="关键字">
                        <i-input type="textarea" placeholder="请输入关键字" v-model="form.page.description"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="14">
                    <form-item>
                        <i-button :loading="loading" type="primary" @click.native="submit">
                            <span v-if="!loading">{{ trans('content.global.publish.submit') }}</span>
                            <span v-else>{{ trans('content.global.publish.loading') }}</span>
                        </i-button>
                    </form-item>
                </i-col>
            </row>
        </card>
    </i-form>
</template>
