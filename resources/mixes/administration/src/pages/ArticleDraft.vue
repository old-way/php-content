<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('content');
            });
        },
        data() {
            const self = this;
            return {
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
                        render(h, data) {
                            return h('div', [
                                h('router-link', {
                                    to: '',
                                }, [
                                    h('i-button', {
                                        on: {
                                            click() {
                                                self.edit(data.index);
                                            },
                                        },
                                        props: {
                                            type: 'primary',
                                        },
                                    }, injection.trans('content.global.edit.submit')),
                                ]),
                                h('i-button', {
                                    on: {
                                        click() {
                                            self.remove(data.index);
                                        },
                                    },
                                    props: {
                                        type: 'error',
                                    },
                                }, injection.trans('content.global.delete.submit')),
                            ]);
                        },
                        title: '操作',
                        width: 200,
                    },
                ],
                list: [
                    {
                        title: 'dsdfsdfs0',
                        author: 'sdfsdf',
                        enabled: true,
                    },
                    {
                        title: 'dsdfsdfs0',
                        author: 'sdfsdf',
                        enabled: true,
                    },
                    {
                        title: 'dsdfsdfs0',
                        author: 'sdfsdf',
                        enabled: true,
                    },
                    {
                        title: 'dsdfsdfs0',
                        author: 'sdfsdf',
                        enabled: true,
                    },
                    {
                        title: 'dsdfsdfs0',
                        author: 'sdfsdf',
                        enabled: true,
                    },
                ],
                self: this,
                trans: injection.trans,
            };
        },
        methods: {
            remove(index) {
                console.log(index);
            },
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-list">
            <card :bordered="false">
                <template slot="title">
                    <div class="filter">
                        <i-select clearable style="width:200px">
                            <!--<i-option v-for="item in cityList" :value="item.value">{{ item.label }}</i-option>-->
                        </i-select>
                        <router-link to="/content/article/create">
                            <i-button type="primary">添加文章</i-button>
                        </router-link>
                        <i-button type="success">{{ trans('content.global.choose') }}</i-button>
                        <i-button type="error">{{ trans('content.global.delete.submit') }}</i-button>
                    </div>
                </template>
                <i-table :columns="columns" :context="self" :data="list"></i-table>
            </card>
        </div>
    </div>
</template>