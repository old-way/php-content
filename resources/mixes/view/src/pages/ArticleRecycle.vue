<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
                injection.sidebar.active('content');
            });
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-list">
            <card>
                <template slot="title">
                    <div class="filter">
                        <i-select clearable style="width:200px">
                            <!--<i-option v-for="item in cityList" :value="item.value">{{ item.label }}</i-option>-->
                        </i-select>
                        <router-link to="/content/article/create">
                            <i-button type="primary">添加文章</i-button>
                        </router-link>
                        <i-button type="success">选择</i-button>
                        <i-button type="error">删除</i-button>
                    </div>
                </template>
            </card>
        </div>
    </div>
</template>
