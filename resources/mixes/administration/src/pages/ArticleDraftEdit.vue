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
        <div class="article-edit">
            <card :bordered="false">
                <p slot="title">编辑草稿</p>
            </card>
        </div>
    </div>
</template>