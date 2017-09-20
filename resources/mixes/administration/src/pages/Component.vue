<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/content/component/get`).then(response => {
                const { data } = response.data;
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
                        title: injection.trans('content.component.info.success'),
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
        <card :bordered="false">
            <p slot="title">{{ trans('content.component.info.article') }}</p>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.article.title.label')">
                        <i-input :placeholder="trans('content.component.form.article.title.placeholder')"
                                 v-model="form.article.title" :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.article.keyword.label')">
                        <i-input type="textarea"
                                 :placeholder="trans('content.component.form.article.keyword.placeholder')"
                                 v-model="form.article.keyword"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.article.description.label')">
                        <i-input type="textarea"
                                 :placeholder="trans('content.component.form.article.description.placeholder')"
                                 v-model="form.article.description"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
        </card>
        <card :bordered="false">
            <p slot="title">{{ trans('content.component.info.category') }}</p>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.category.title.label')">
                        <i-input :placeholder="trans('content.component.form.category.title.placeholder')"
                                 v-model="form.category.title" :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.category.keyword.label')">
                        <i-input type="textarea"
                                 :placeholder="trans('content.component.form.category.keyword.placeholder')"
                                 v-model="form.category.keyword"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.category.description.label')">
                        <i-input type="textarea"
                                 :placeholder="trans('content.component.form.category.description.placeholder')"
                                 v-model="form.category.description"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
        </card>
        <card :bordered="false">
            <p slot="title">{{ trans('content.component.info.page') }}</p>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.page.title.label')">
                        <i-input :placeholder="trans('content.component.form.page.title.placeholder')"
                                 v-model="form.page.title" :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.page.keyword.label')">
                        <i-input type="textarea" :placeholder="trans('content.component.form.page.keyword.placeholder')"
                                 v-model="form.page.keyword"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="12">
                    <form-item :label="trans('content.component.form.page.description.label')">
                        <i-input type="textarea"
                                 :placeholder="trans('content.component.form.page.description.placeholder')"
                                 v-model="form.page.description"
                                 :autosize="{minRows: 2,maxRows: 5}"></i-input>
                    </form-item>
                </i-col>
            </row>
            <row>
                <i-col span="12">
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