<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('content');
            });
        },
        data() {
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
                        render(row, column, index) {
                            return `<i-switch v-model="list[${index}].enabled" @on-change="statusChanged(${index})"></i-switch>`;
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
            };
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-list">
            <card>
                <template slot="title">
                    <i-input class="search" placeholder="请输入搜索关键字">
                        <i-button slot="append" icon="ios-search"></i-button>
                    </i-input>
                    <div class="filter">
                        <i-select clearable style="width:200px">
                            <!--<i-option v-for="item in cityList" :value="item.value">{{ item.label }}</i-option>-->
                        </i-select>
                        <router-link to="/content/article/create">
                            <i-button type="primary">添加文章</i-button>
                        </router-link>
                        <i-button type="error">删除</i-button>
                    </div>
                </template>
                <i-table :columns="columns" :content="self" :data="list"></i-table>
            </card>
        </div>
    </div>
</template>
