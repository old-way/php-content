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
    <div class="article-warp">
        <div class="article-edit">
            <card>
                <p slot="title">创建文章</p>
            </card>
        </div>
    </div>
</template>
