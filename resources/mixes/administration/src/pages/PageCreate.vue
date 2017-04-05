<script>
    import Editor from '../components/Editor';
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/page/category/fetch`).then(response => {
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
                    alias: '',
                    category: {
                        id: 0,
                        list: [],
                        text: '选择分类[未分类(0)]',
                    },
                    content: '',
                    enabled: false,
                    title: '',
                },
                loading: false,
                path: window.UEDITOR_HOME_URL,
                rules: {
                    alias: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入页面别名',
                            trigger: 'change',
                        },
                    ],
                    content: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入页面内容',
                            trigger: 'change',
                        },
                    ],
                    title: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入页面标题',
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
                        formData.append('alias', self.form.alias);
                        formData.append('category_id', self.form.category.id[self.form.category.id.length - 1]);
                        formData.append('content', self.form.content);
                        formData.append('enabled', self.form.enabled ? '1' : '0');
                        formData.append('title', self.form.title);
                        self.$http.post(`${window.api}/page/create`, formData).then(response => {
                            self.$notice.open({
                                title: response.data.message,
                            });
                            self.$router.push('/content/page');
                        }).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '填写内容不完整或填写错误！',
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
            <card>
                <p slot="title">创建页面</p>
                <row>
                    <i-col offset="4" span="16">
                        <i-form label-position="top" :model="form" ref="form" :rules="rules">
                            <form-item label="标题" prop="title">
                                <i-input placeholder="请输入页面标题" v-model="form.title"></i-input>
                            </form-item>
                            <form-item label="别名" prop="alias">
                                <i-input placeholder="请输入页面标题" v-model="form.alias"></i-input>
                            </form-item>
                            <form-item label="分类">
                                <cascader :data="form.category.list" v-model="form.category.id"></cascader>
                            </form-item>
                            <form-item label="开启" prop="enabled">
                                <i-switch v-model="form.enabled" size="large">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                </i-switch>
                            </form-item>
                            <form-item label="内容" prop="content">
                                <editor :path="path" @ready="editor"></editor>
                            </form-item>
                            <form-item>
                                <i-button :loading="loading" type="primary" @click.native="submit">
                                    <span v-if="!loading">确认提交</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                            </form-item>
                        </i-form>
                    </i-col>
                </row>
            </card>
        </div>
    </div>
</template>
