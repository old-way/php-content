<script>
    export default {
        name: 'Editor',
        data() {
            return {
                // 为了避免麻烦，每个编辑器实例都用不同的 id
                randomId: `editor_${(Math.random() * 100000000000000000)}`,
                instance: null,
                // scriptTagStatus -> 0:代码未加载，1:两个代码依赖加载了一个，2:两个代码依赖都已经加载完成
                scriptTagStatus: 0,
            };
        },
        created() {
            if (window.UE !== undefined) {
                // 如果全局对象存在，说明编辑器代码已经初始化完成，直接加载编辑器
                this.scriptTagStatus = 2;
                this.initEditor();
            } else {
                // 如果全局对象不存在，说明编辑器代码还没有加载完成，需要加载编辑器代码
                this.insertScriptTag();
            }
        },
        beforeDestroy() {
            // 组件销毁的时候，要销毁 UEditor 实例
            if (this.instance !== null && this.instance.destroy) {
                this.instance.destroy();
            }
        },
        methods: {
            insertScriptTag() {
                const self = this;
                let editorScriptTag = document.getElementById('editorScriptTag');
                let configScriptTag = document.getElementById('configScriptTag');

                // 如果这个tag不存在，则生成相关代码tag以加载代码
                if (editorScriptTag === null) {
                    configScriptTag = document.createElement('script');
                    configScriptTag.type = 'text/javascript';
                    configScriptTag.src = `${self.path}neditor.config.js`;
                    configScriptTag.id = 'configScriptTag';

                    editorScriptTag = document.createElement('script');
                    editorScriptTag.type = 'text/javascript';
                    editorScriptTag.src = `${self.path}neditor.all.min.js`;
                    editorScriptTag.id = 'editorScriptTag';
                    const s = document.getElementsByTagName('head')[0];
                    s.appendChild(configScriptTag);
                    s.appendChild(editorScriptTag);
                }

                // 等待代码加载完成后初始化编辑器
                if (configScriptTag.loaded) {
                    self.scriptTagStatus += 1;
                } else {
                    configScriptTag.addEventListener('load', () => {
                        self.scriptTagStatus += 1;
                        configScriptTag.loaded = true;
                        self.initEditor();
                    });
                }

                if (editorScriptTag.loaded) {
                    self.scriptTagStatus += 1;
                } else {
                    editorScriptTag.addEventListener('load', () => {
                        self.scriptTagStatus += 1;
                        editorScriptTag.loaded = true;
                        self.initEditor();
                    });
                }

                self.initEditor();
            },
            initEditor() {
                const self = this;
                // scriptTagStatus 为 2 的时候，说明两个必需引入的 js 文件都已经被引入，且加载完成
                if (self.scriptTagStatus === 2 && self.instance === null) {
                    // Vue 异步执行 DOM 更新，这样一来代码执行到这里的时候可能 template 里面的 script 标签还没真正创建
                    // 所以，我们只能在 nextTick 里面初始化 UEditor
                    self.$nextTick(() => {
                        self.instance = window.UE.getEditor(self.randomId, self.config);
                        // 绑定事件，当 UEditor 初始化完成后，将编辑器实例通过自定义的 ready 事件交出去
                        self.instance.addListener('ready', () => {
                            this.$emit('ready', this.instance);
                        });
                    });
                }
            },
        },
        props: {
            config: {
                // UEditor 配置项
                type: Object,
                default() {
                    return {};
                },
            },
            path: {
                // UEditor 代码的路径
                type: String,
                default: '/',
            },
        },
    };
</script>
<template>
    <div :id="randomId" name="content" type="text/plain"></div>
</template>