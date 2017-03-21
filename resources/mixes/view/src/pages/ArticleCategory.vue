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
        <div class="article-category">
            <card>
                <p slot="title">文章分类管理</p>
            </card>
        </div>
    </div>
</template>
