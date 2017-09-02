<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/content/category/list`).then(response => {
                const list = response.data.data;
                next(vm => {
                    vm.categories = list.map(first => ({
                        children: Object.keys(first.children).map(i => {
                            const second = first.children[i];
                            return {
                                children: Object.keys(second.children).map(n => {
                                    const third = second.children[n];
                                    return {
                                        children: [],
                                        label: third.title,
                                        value: third.id,
                                    };
                                }),
                                label: second.title,
                                value: second.id,
                            };
                        }),
                        label: first.title,
                        value: first.id,
                    }));
                    injection.loading.finish();
                    injection.message.info(injection.trans('content.article.category.info.get'));
                    injection.sidebar.active('content');
                });
            }).catch(() => {
                injection.loading.fail();
            });
        },
        data() {
            return {
                action: `${window.api}/content/upload`,
                categories: [],
                form: {
                    category: [],
                    content: '',
                    created_at: '',
                    description: '',
                    image: '',
                    is_hidden: false,
                    is_sticky: false,
                    keyword: [],
                    source: {
                        author: '',
                        link: 'http://',
                    },
                    summery: '',
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
                    summery: [
                        {
                            required: true,
                            type: 'string',
                            message: '简介不能为空',
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
            submit() {
                const self = this;
                self.loading = true;
                self.$refs.form.validate(valid => {
                    if (valid) {
                        const formData = new window.FormData();
                        formData.append('category_id', self.form.category.length ? self.form.category[self.form.category.length - 1] : 0);
                        formData.append('content', self.form.content);
                        formData.append('summery', self.form.summery);
                        formData.append('created_at', self.form.created_at);
                        formData.append('description', self.form.description);
                        formData.append('thumb_image', self.form.image ? self.form.image : '');
                        formData.append('is_hidden', self.form.is_hidden ? '1' : '0');
                        formData.append('is_sticky', self.form.is_sticky ? '1' : '0');
                        formData.append('keyword', self.form.keyword);
                        formData.append('source_author', self.form.source.author);
                        formData.append('title', self.form.title);
                        if (self.form.source.link === 'http://') {
                            formData.append('source_link', '');
                        } else if (self.form.source.link === 'https://') {
                            formData.append('source_link', '');
                        } else {
                            formData.append('source_link', self.form.source.link);
                        }
                        self.$http.post(`${window.api}/content/article/create`, formData).then(() => {
                            self.$notice.open({
                                title: '创建文章信息成功！',
                            });
                            self.$router.push('/content/article');
                        }).catch(() => {
                            self.$notice.error({
                                title: '创建文章信息失败！',
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
            uploadBefore() {
                this.$loading.start();
            },
            uploadError(error, data) {
                const self = this;
                self.$loading.error();
                Object.keys(data.message).forEach(index => {
                    self.$notice.error({
                        title: data.message[index],
                    });
                });
            },
            uploadFormatError(file) {
                this.$notice.warning({
                    title: '文件格式不正确',
                    desc: `文件 ${file.name} 格式不正确，请上传 jpg 或 png 格式的图片。`,
                });
            },
            uploadSuccess(data) {
                const self = this;
                self.$loading.finish();
                self.$notice.open({
                    title: data.message,
                });
                self.form.image = data.data.path;
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
                                <editor :path="path" v-model="form.content"></editor>
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
                        <card :bordered="false">
                            <form-item label="缩略图" prop="image">
                                <div class="ivu-upload-wrapper">
                                    <div class="preview" v-if="form.image">
                                        <img :src="form.image">
                                        <icon type="close" @click.native="removeImage"></icon>
                                    </div>
                                    <upload :action="action"
                                            :before-upload="uploadBefore"
                                            :format="['jpg','jpeg','png']"
                                            :headers="{
                                                    Authorization: `Bearer ${$store.state.token.access_token}`
                                                }"
                                            :max-size="2048"
                                            :on-error="uploadError"
                                            :on-format-error="uploadFormatError"
                                            :on-success="uploadSuccess"
                                            ref="upload"
                                            :show-upload-list="false"
                                            v-if="form.image === '' || form.image === null">
                                    </upload>
                                </div>
                            </form-item>
                            <form-item :label="trans('content.article.form.category.label')">
                                <cascader :data="categories" v-model="form.category"></cascader>
                            </form-item>
                            <form-item label="摘要" prop="summery">
                                <i-input placeholder="请输入文章简介"
                                         :rows="4"
                                         type="textarea"
                                         v-model="form.summery"></i-input>
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
                                             v-model="form.created_at"
                                             type="datetime"></date-picker>
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