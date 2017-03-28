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
        <div class="article-tag">
            <card>
                <p slot="title">文章标签</p>
            </card>
        </div>
    </div>
</template>
