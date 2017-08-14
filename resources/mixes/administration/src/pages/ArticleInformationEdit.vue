<script>
    import fields from '../helpers/fields';
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/content/article/information`, {
                id: to.params.id,
            }).then(response => {
                const categories = response.data.categories;
                const informations = response.data.data;
                next(vm => {
                    vm.form = informations;
                    vm.form.categories = [];
                    Object.keys(categories).forEach(index => {
                        categories[index].label = categories[index].id;
                        categories[index].text = categories[index].title;
                        if (categories[index].exists) {
                            vm.form.categories.push(categories[index].id);
                        }
                        if (categories[index].children.length) {
                            Object.keys(categories[index].children).forEach(node => {
                                categories[index].children[node].label
                                    = categories[index].children[node].id;
                                categories[index].children[node].text
                                    = categories[index].children[node].title;
                                if (categories[index].children[node].exists) {
                                    vm.form.categories.push(categories[index].children[node].id);
                                }
                                if (categories[index].children[node].children.length) {
                                    Object.keys(categories[index].children[node].children)
                                        .forEach(that => {
                                            categories[index].children[node].children[that].label
                                                = categories[index].children[node].children[that].id;
                                            categories[index].children[node].children[that].text
                                                = categories[index].children[node].children[that].title;
                                            if (categories[index].children[node]
                                                    .children[that].exists) {
                                                vm.form.categories.push(categories[index]
                                                    .children[node].children[that].id);
                                            }
                                        });
                                }
                            });
                        }
                    });
                    window.console.log(vm.form);
                    vm.categories = categories;
                    window.console.log(vm.categories);
                    injection.loading.finish();
                    injection.sidebar.active('content');
                });
            }).catch(() => {
                injection.loading.error();
            });
        },
        data() {
            return {
                form: {
                    description: '',
                    categories: [],
                    length: 0,
                    name: '',
                    opinions: '',
                    order: 0,
                    required: false,
                    type: 'input',
                },
                categories: [],
                loading: false,
                rules: {
                    name: [
                        {
                            message: '请输入信息项名称',
                            required: true,
                            trigger: 'change',
                            type: 'string',
                        },
                    ],
                },
                types: fields,
            };
        },
        methods: {
            submit() {
                const self = this;
                self.loading = true;
                self.$refs.form.validate(valid => {
                    if (valid) {
                        self.$http.post(`${window.api}/content/article/information/edit`, self.form).then(() => {
                            self.$notice.open({
                                title: '创建信息项成功！',
                            });
                            self.$router.push('/content/article/information');
                        }).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.$notice.error({
                            title: '请正确填写表单内容！',
                        });
                        self.loading = false;
                    }
                });
            },
        },
    };
</script>
<template>
    <div class="member-warp">
        <div class="user-create">
            <card :bordered="false">
                <p slot="title">创建信息项</p>
                <i-form :label-width="200" :model="form" ref="form" :rules="rules">
                    <row>
                        <i-col span="12">
                            <form-item label="信息项名称" prop="name">
                                <i-input placeholder="请输入信息项名称" v-model="form.name"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="信息项介绍" prop="description">
                                <i-input placeholder="请输入信息项介绍" v-model="form.description"></i-input>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="表单类型">
                                <radio-group v-model="form.type" vertical>
                                    <radio :label="item.label" v-for="item in types">
                                        <span>{{ item.text }}</span>
                                    </radio>
                                </radio-group>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="大小限定" prop="length">
                                <i-input placeholder="请输入信息项介绍" v-model="form.length"></i-input>
                                <p>最多可填写的字符数或最多可选择的项数,图片类型时限制了上传图片大小(单位:KB)。</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="可选值" prop="opinions">
                                <i-input type="textarea" placeholder="请输入可选值列表" v-model="form.opinions"
                                         :autosize="{minRows: 5,maxRows: 9}"></i-input>
                                <p>每行一个值，例如输入:</p>
                                <p>北京</p>
                                <p>上海</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="必填项">
                                <i-switch v-model="form.required" size="large">
                                    <span slot="open">开启</span>
                                    <span slot="close">关闭</span>
                                </i-switch>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="显示顺序" prop="order">
                                <i-input placeholder="请输入显示顺序" v-model="form.order"></i-input>
                                <p>值越大显示越靠后。默认为 0 。</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item label="所属分类">
                                <checkbox-group v-model="form.categories">
                                    <div v-for="item in categories">
                                        <checkbox :label="item.label">
                                            <span>{{ item.text }}</span>
                                        </checkbox>
                                        <div style="margin-left: 60px" v-for="child in item.children"
                                             v-if="item.children">
                                            <checkbox :label="child.label">
                                                <span>{{ child.text }}</span>
                                            </checkbox>
                                            <div style="margin-left: 60px" v-for="sub in child.children"
                                                 v-if="child.children">
                                                <checkbox :label="sub.label">
                                                    <span>{{ sub.text }}</span>
                                                </checkbox>
                                            </div>
                                        </div>
                                    </div>
                                </checkbox-group>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="12">
                            <form-item>
                                <i-button :loading="loading" type="primary" @click.native="submit">
                                    <span v-if="!loading">确认提交</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                            </form-item>
                        </i-col>
                    </row>
                </i-form>
            </card>
        </div>
    </div>
</template>