<script>
    export default {
        beforeRouteEnter(to, from, next) {
            next(() => {
            });
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-tag">
            <card :bordered="false">
                <p slot="title">文章标签</p>
            </card>
        </div>
    </div>
</template>