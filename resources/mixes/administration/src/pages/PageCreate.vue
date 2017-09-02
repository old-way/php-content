<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/content/page/category/list`).then(response => {
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
                    injection.message.info(injection.trans('content.page.category.info.fetch'));
                    injection.sidebar.active('content');
                });
            }).catch(() => {
                injection.loading.fail();
            });
        },
        data() {
            return {
                form: {
                    alias: '',
                    category: {
                        id: 0,
                        list: [],
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
                            message: injection.trans('content.page.form.alias.error'),
                            trigger: 'change',
                        },
                    ],
                    content: [
                        {
                            required: true,
                            type: 'string',
                            message: injection.trans('content.page.form.content.error'),
                            trigger: 'change',
                        },
                    ],
                    title: [
                        {
                            required: true,
                            type: 'string',
                            message: injection.trans('content.page.form.title.error'),
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
                        formData.append('alias', self.form.alias);
                        formData.append('category_id', self.form.category.id ? self.form.category.id[self.form.category.id.length - 1] : 0);
                        formData.append('content', self.form.content);
                        formData.append('enabled', self.form.enabled ? '1' : '0');
                        formData.append('title', self.form.title);
                        self.$http.post(`${window.api}/content/page/create`, formData).then(response => {
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
                            title: injection.trans('content.page.info.error'),
                        });
                    }
                });
            },
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-edit">
            <card :bordered="false">
                <p slot="title">{{ trans('content.page.info.create') }}</p>
                <row>
                    <i-col offset="4" span="16">
                        <i-form label-position="top" :model="form" ref="form" :rules="rules">
                            <form-item :label="trans('content.page.form.title.label')" prop="title">
                                <i-input :placeholder="trans('content.page.form.title.placeholder')" v-model="form.title"></i-input>
                            </form-item>
                            <form-item :label="trans('content.page.form.alias.label')" prop="alias">
                                <i-input :placeholder="trans('content.page.form.alias.placeholder')" v-model="form.alias"></i-input>
                            </form-item>
                            <form-item :label="trans('content.page.form.category.label')">
                                <cascader :data="form.category.list" v-model="form.category.id"></cascader>
                            </form-item>
                            <form-item :label="trans('content.page.form.enabled.label')" prop="enabled">
                                <i-switch v-model="form.enabled" size="large">
                                    <span slot="open">{{ trans('content.page.form.enabled.open') }}</span>
                                    <span slot="close">{{ trans('content.page.form.enabled.close') }}</span>
                                </i-switch>
                            </form-item>
                            <form-item :label="trans('content.page.form.content.label')" prop="content">
                                <editor :path="path"  v-model="form.content"></editor>
                            </form-item>
                            <form-item>
                                <i-button :loading="loading" type="primary" @click.native="submit">
                                    <span v-if="!loading">{{ trans('content.global.publish.submit') }}</span>
                                    <span v-else>{{ trans('content.global.publish.loading') }}</span>
                                </i-button>
                            </form-item>
                        </i-form>
                    </i-col>
                </row>
            </card>
        </div>
    </div>
</template>