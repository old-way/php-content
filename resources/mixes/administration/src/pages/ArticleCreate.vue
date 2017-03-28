<script>
    import Editor from '../components/Editor';
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/category/fetch`).then(response => {
                const list = response.data.data;
                next(vm => {
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
                    injection.loading.finish();
                    injection.message.info('获取分类列表成功！');
                    injection.sidebar.active('content');
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
                        text: '选择分类[未分类(0)]',
                    },
                    content: '',
                    date: '',
                    hidden: false,
                    image: '',
                    source: {
                        author: '',
                        link: '',
                    },
                    sticky: false,
                    summary: '',
                    tags: [],
                    title: '',
                },
                loading: false,
                path: window.UEDITOR_HOME_URL,
                rules: {
                    content: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入文章内容',
                            trigger: 'change',
                        },
                    ],
                    title: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入文章标题',
                            trigger: 'change',
                        },
                    ],
                },
            };
        },
        methods: {
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
                        formData.append('category_id', self.form.category.id[self.form.category.id.length - 1]);
                        formData.append('content', self.form.content);
                        formData.append('date', self.form.date);
                        formData.append('hidden', self.form.hidden ? '1' : '0');
                        formData.append('image', self.form.image);
                        formData.append('sticky', self.form.sticky ? '1' : '0');
                        formData.append('summary', self.form.summary);
                        formData.append('tags', self.form.tags);
                        formData.append('title', self.form.title);
                        formData.append('source_author', self.form.source.author);
                        formData.append('source_link', self.form.source.link);
                        self.$http.post(`${window.api}/article/create`, formData).then(response => {
                            self.$notice.open({
                                title: response.data.message,
                            });
                            self.$router.push('/content/article');
                        }).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请先填写文章内容！',
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
                        <card>
                            <form-item prop="title">
                                <i-input placeholder="请输入文章标题" v-model="form.title"></i-input>
                            </form-item>
                            <form-item prop="content">
                                <editor :path="path" @ready="editor"></editor>
                            </form-item>
                            <form-item>
                                <i-button :loading="loading" type="primary" @click.native="submit">
                                    <span v-if="!loading">确认提交</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                            </form-item>
                        </card>
                    </i-col>
                    <i-col span="8">
                        <!--<card>-->
                            <!--<p slot="title">草稿箱</p>-->
                        <!--</card>-->
                        <card>
                            <!--<form-item label="缩略图" prop="image">-->
                                <!--<upload action="//jsonplaceholder.typicode.com/posts/">-->
                                    <!--<i-button type="ghost" icon="ios-cloud-upload-outline">上传文件</i-button>-->
                                <!--</upload>-->
                            <!--</form-item>-->
                            <form-item label="分类">
                                <cascader :data="form.category.list" v-model="form.category.id"></cascader>
                            </form-item>
                            <form-item label="置顶" prop="sticky">
                                <i-switch v-model="form.sticky" size="large">
                                    <span slot="open">置顶</span>
                                    <span slot="close">取消</span>
                                </i-switch>
                            </form-item>
                            <form-item label="隐藏" prop="hidden">
                                <i-switch v-model="form.hidden" size="large">
                                    <span slot="open">隐藏</span>
                                    <span slot="close">取消</span>
                                </i-switch>
                            </form-item>
                            <form-item label="发布时间">
                                <date-picker placeholder="请选择发布时间" type="date" v-model="form.date"></date-picker>
                            </form-item>
                            <form-item label="来源">
                                <i-input placeholder="请输入来源" v-model="form.source.author"></i-input>
                            </form-item>
                            <form-item label="来源链接">
                                <i-input placeholder="请输入来源链接" v-model="form.source.link"></i-input>
                            </form-item>
                        </card>
                    </i-col>
                </row>
            </i-form>
        </div>
    </div>
</template>
