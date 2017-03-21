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
        <div class="article-list">
            <card>
                <p slot="title">回收站</p>
            </card>
        </div>
    </div>
</template>
