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
                form: {
                    title: '',
                },
                loading: false,
                rules: {
                    title: [
                        {
                            required: true,
                            type: 'string',
                            message: '请输入文章标题',
                            trigger: 'change',
                        },
                    ],
                },
            };
        },
    };
</script>
<template>
    <div class="article-wrap">
        <div class="article-edit">
            <i-form :label-width="200" :form="form" ref="form" :rules="rules">
                <row :gutter="20">
                    <i-col span="18">
                        <card>
                            <form-item>
                                <i-input placeholder="请输入文章标题"></i-input>
                            </form-item>
                        </card>
                    </i-col>
                    <i-col span="6">
                        <card>
                            <p slot="title">创建文章</p>
                        </card>
                    </i-col>
                </row>
            </i-form>
        </div>
    </div>
</template>
