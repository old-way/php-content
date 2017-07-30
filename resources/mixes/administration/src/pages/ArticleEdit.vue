<script>
    import Editor from '../components/Editor.vue';
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/content/article`, {
                id: to.params.id,
            }).then(response => {
                const article = response.data.data;
                injection.message.info(injection.trans('content.article.info.get'));
                injection.http.post(`${window.api}/content/category/list`).then(result => {
                    const list = result.data.data;
                    next(vm => {
                        vm.form.category.id = article.category_path ? article.category_path : [];
                        vm.form.category.list = list.map(first => ({
                            children: first.children.map(second => ({
                                children: second.children.map(third => ({
                                    children: [],
                                    label: third.title,
                                    value: third.id,
                                })),
                                label: second.title,
                                value: second.id,
                            })),
                            label: first.title,
                            value: first.id,
                        }));
                        vm.form.content = article.content;
                        vm.form.created_at = article.created_at;
                        vm.form.description = article.description;
                        vm.form.image = article.thumb_image ? `${window.url}/${article.thumb_image}` : '';
                        vm.form.is_hidden = article.is_hidden === 1;
                        vm.form.is_sticky = article.is_sticky === 1;
//                    if (article.keyword.length) {
//                        vm.form.keyword = article.keyword.split(',');
//                    }
                        vm.form.source = {
                            author: article.source_author,
                            link: article.source_link,
                        };
                        vm.form.title = article.title;
                        injection.loading.finish();
                        injection.message.info(injection.trans('content.article.category.info.get'));
                        injection.sidebar.active('content');
                    });
                }).catch(() => {
                    injection.loading.fail();
                });
            }).catch(() => {
                injection.loading.fail();
            });
        },
        components: {
            Editor,
        },
        data() {
            return {
                form: {
                    category: {
                        id: 0,
                        list: [],
                    },
                    content: '',
                    created_at: '',
                    description: '',
                    is_hidden: false,
                    is_sticky: false,
                    image: '',
                    keyword: [],
                    source: {
                        author: '',
                        link: '',
                    },
                    title: '',
                },
                loading: false,
                path: window.UEDITOR_HOME_URL,
                rules: {
                    content: [
                        {
                            required: true,
                            type: 'string',
                            message: injection.trans('content.article.form.content.error'),
                            trigger: 'change',
                        },
                    ],
                    title: [
                        {
                            required: true,
                            type: 'string',
                            message: injection.trans('content.article.form.title.error'),
                            trigger: 'change',
                        },
                    ],
                },
                trans: injection.trans,
            };
        },
        methods: {
            dateChange(val) {
                this.form.created_at = val;
            },
            editor(instance) {
                const self = this;
                instance.setContent(self.form.content);
                instance.addListener('contentChange', () => {
                    self.form.content = instance.getContent();
                });
            },
            submit() {
                const self = this;
                self.loading = true;
                self.$refs.form.validate(valid => {
                    if (valid) {
                        const formData = new window.FormData();
                        formData.append('category_id', self.form.category.id.length ? self.form.category.id[self.form.category.id.length - 1] : 0);
                        formData.append('content', self.form.content);
                        formData.append('created_at', self.form.created_at);
                        formData.append('is_hidden', self.form.is_hidden ? '1' : '0');
                        formData.append('id', self.$route.params.id);
                        formData.append('image', self.form.image);
                        formData.append('is_sticky', self.form.is_sticky ? '1' : '0');
                        formData.append('description', self.form.description);
                        formData.append('keyword', self.form.keyword);
                        formData.append('title', self.form.title);
                        formData.append('source_author', self.form.source.author);
                        formData.append('source_link', self.form.source.link);
                        window.console.log(self.form);
                        self.$http.post(`${window.api}/content/article/edit`, formData).then(response => {
                            self.$notice.open({
                                title: '编辑文章信息成功！',
                            });
                            self.$router.push('/content/article');
                        }).catch(() => {
                            self.$notice.error({
                                title: '编辑文章信息失败！',
                            });
                        }).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: injection.trans('content.article.info.error'),
                        });
                    }
                });
            },
        },
        watch: {
            'form.content': {
                handler() {
                    this.$refs.form.validateField('content');
                },
            },
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-edit">
            <i-form label-position="top" :model="form" ref="form" :rules="rules">
                <row :gutter="20">
                    <i-col span="16">
                        <card :bordered="false">
                            <form-item prop="title">
                                <i-input :placeholder="trans('content.article.form.title.placeholder')"
                                         v-model="form.title"></i-input>
                            </form-item>
                            <form-item prop="content">
                                <editor :path="path" @ready="editor"></editor>
                            </form-item>
                            <form-item>
                                <i-button :loading="loading" type="primary" @click.native="submit">
                                    <span v-if="!loading">{{ trans('content.global.publish.submit') }}</span>
                                    <span v-else>{{ trans('content.global.publish.loading') }}</span>
                                </i-button>
                            </form-item>
                        </card>
                    </i-col>
                    <i-col span="8">
                        <!--<card :bordered="false">-->
                        <!--<p slot="title">草稿箱</p>-->
                        <!--</card>-->
                        <card :bordered="false">
                            <!--<form-item label="缩略图" prop="image">-->
                            <!--<upload action="//jsonplaceholder.typicode.com/posts/">-->
                            <!--<i-button type="ghost" icon="ios-cloud-upload-outline">上传文件</i-button>-->
                            <!--</upload>-->
                            <!--</form-item>-->
                            <form-item :label="trans('content.article.form.category.label')">
                                <cascader :data="form.category.list" v-model="form.category.id"></cascader>
                            </form-item>
                            <form-item :label="trans('content.article.form.sticky.label')" prop="sticky">
                                <i-switch v-model="form.is_sticky" size="large">
                                    <span slot="open">{{ trans('content.article.form.sticky.open') }}</span>
                                    <span slot="close">{{ trans('content.article.form.sticky.close') }}</span>
                                </i-switch>
                            </form-item>
                            <form-item :label="trans('content.article.form.hidden.label')" prop="hidden">
                                <i-switch v-model="form.is_hidden" size="large">
                                    <span slot="open">{{ trans('content.article.form.hidden.open') }}</span>
                                    <span slot="close">{{ trans('content.article.form.hidden.close') }}</span>
                                </i-switch>
                            </form-item>
                            <form-item :label="trans('content.article.form.date.label')">
                                <date-picker :placeholder="trans('content.article.form.date.placeholder')"
                                             type="datetime" @on-change="dateChange"></date-picker>
                            </form-item>
                            <form-item :label="trans('content.article.form.source.author.label')">
                                <i-input :placeholder="trans('content.article.form.source.author.placeholder')"
                                         v-model="form.source.author"></i-input>
                            </form-item>
                            <form-item :label="trans('content.article.form.source.link.label')">
                                <i-input :placeholder="trans('content.article.form.source.link.placeholder')"
                                         v-model="form.source.link"></i-input>
                            </form-item>
                        </card>
                    </i-col>
                </row>
            </i-form>
        </div>
    </div>
</template>