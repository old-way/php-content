<script>
  import Core from '../main'
  export default {
    beforeCreate: function () {
      this.$options.components.Modal = Core.instance.components.modal
    },
    beforeRouteEnter (to, from, next) {
      Core.instance.store.commit('progress', 'start')
      Core.http.post(window.api + '/category/fetch').then(function (response) {
        Core.instance.store.commit('progress', 'done')
        next((vm) => {
          vm.items = response.data.data
        })
      }).catch(() => {
        Core.instance.store.commit('progress', 'fail')
      })
    },
    data () {
      return {
        items: [],
        modal: {
          alias: '',
          background_color: '',
          background_image: '',
          description: '',
          enabled: '',
          id: 0,
          link: '',
          name: '',
          pattern: 'create',
          pagination: 30,
          seo_title: '',
          seo_keyword: '',
          seo_description: '',
          title: '创建分类',
          top_image: ''
        },
        none: false,
        order: {}
      }
    },
    methods: {
      create: function () {
        this.modal.alias = ''
        this.modal.background_color = ''
        this.modal.background_image = ''
        this.modal.description = ''
        this.modal.enabled = '1'
        this.modal.id = 0
        this.modal.link = ''
        this.modal.name = ''
        this.modal.pattern = 'create'
        this.modal.pagination = 30
        this.modal.seo_title = ''
        this.modal.seo_keyword = ''
        this.modal.seo_description = ''
        this.modal.title = '创建分类'
        this.modal.top_image = ''
        this.$refs.modal.open()
      },
      edit: function (item) {
        this.modal.alias = item.alias
        this.modal.background_color = item.background_color
        this.modal.background_image = item.background_image
        this.modal.description = item.description
        this.modal.enabled = item.enabled
        this.modal.id = item.id
        this.modal.link = item.link
        this.modal.name = item.title
        this.modal.pattern = 'edit'
        this.modal.pagination = 30
        this.modal.seo_title = item.seo_title
        this.modal.seo_keyword = item.seo_keyword
        this.modal.seo_description = item.seo_description
        this.modal.title = '编辑分类：' + item.title
        this.modal.top_image = item.top_image
        this.$refs.modal.open()
      },
      remove: function () {
        let _this = this
        if (_this.modal.pattern === 'create') {
          _this.$refs.modal.close()
        }
        if (_this.modal.pattern === 'edit') {
          _this.$http.post(window.api + '/category/delete', _this.modal).then(function (response) {
            _this.items = response.data.data
          }).finally(() => {
            _this.$refs.modal.close()
          })
        }
      },
      submit: function (e) {
        let _this = this
        if (!_this.modal.title || !_this.modal.alias) {
          window.alert('必须填写名称和别名！')
          return false
        }
        if (_this.modal.pattern === 'create') {
          _this.$http.post(window.api + '/category/create', _this.modal).then(function (response) {
            _this.items = response.data.data
            _this.$store.commit('message', {
              show: true,
              type: 'notice',
              text: '创建分类成功！'
            })
          }).finally(() => {
            _this.$refs.modal.close()
          })
        }
        if (_this.modal.pattern === 'edit') {
          _this.$http.post(window.api + '/category/edit', _this.modal).then(function (response) {
            _this.items = response.data.data
            _this.$store.commit('message', {
              show: true,
              type: 'notice',
              text: '编辑分类成功！'
            })
          }).finally(() => {
            _this.$refs.modal.close()
          })
        }
      }
    },
    mounted () {
      let _this = this
      _this.$store.commit('title', '文章分类管理 - 文章 - Notadd Administration')
    },
    updated () {
      let _this = this
      _this.$jquery(_this.$el).find('ul, ol').sortable({
        connectWith: 'article-category'
      })
      _this.$jquery('.col-md-6 > ul.list-group').off('sortstop').on('sortstop', function () {
        _this.order = _this.$jquery('.col-md-6 > ul.list-group > li').map(function () {
          return {
            id: _this.$jquery(this).data('id'),
            children: _this.$jquery(this).children('ol').children('li').map(function () {
              return {
                id: _this.$jquery(this).data('id'),
                children: _this.$jquery(this).find('li').map(function () {
                  return {
                    id: _this.$jquery(this).data('id')
                  }
                }).get()
              }
            }).get()
          }
        }).get()
      })
    },
    watch: {
      order: {
        deep: true,
        handler: function (val, old) {
          console.log(JSON.stringify(val))
          console.log(JSON.stringify(old))
          console.log(JSON.stringify(val) !== JSON.stringify(old))
          let _this = this
          JSON.stringify(val) !== JSON.stringify(old) && _this.$nextTick(function () {
            _this.$http.post(window.api + '/category/sort', {
              data: val
            }).then(function (response) {
              _this.items = []
              _this.$nextTick(function () {
                _this.items = response.data.data
              })
            })
          })
        }
      }
    }
  }
</script>
<style scoped>
    .box-body {
        padding-bottom: 20px;
        padding-top: 20px;
    }

    .list-group > .list-group-item {
        border-width: 0;
        padding: 0;
    }

    .list-group > .list-group-item > .list-group-item-content {
        border-radius: 4px;
        cursor: move;
        height: 30px;
        line-height: 30px;
        margin-top: 5px;
    }

    .list-group > .list-group-item > .list-group-item-content:hover {
        background: #efefef;
    }

    .list-group > .list-group-item > .list-group-item-content > em {
        border-radius: 4px;
        float: left;
        height: 16px;
        margin: 7px;
        width: 16px;
    }

    .list-group > .list-group-item > .list-group-item-content:hover > em {
        opacity: 0;
    }

    .list-group > .list-group-item > .list-group-item-content > .btn {
        background: transparent;
        border-radius: 4px 0 0 4px;
        float: right;
        opacity: 0;
        padding: 5px 10px;
    }

    .list-group > .list-group-item > .list-group-item-content:hover > .btn {
        opacity: 1;
    }

    .list-group > .list-group-item > .list-group {
        margin-bottom: 0;
        padding-left: 26px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group > label {
        font-weight: normal;
    }

    .modal-footer {
        border: none;
        padding: 0;
    }

    .modal-footer > .btn-delete {
        background: none;
        float: right;
        padding-left: 0;
        padding-right: 0;
    }

    .modal-footer > .btn-delete:active {
        background: none;
        box-shadow: none;
    }

    .modal-footer > .btn-delete:hover {
        text-decoration: underline;
    }

    .modal-footer > .btn-submit {
        float: left;
    }

    .none-item {
        background: url("../../static/images/info.svg") left center no-repeat;
        color: #888;
        font-size: 20px;
        height: 40px;
        line-height: 40px;
        margin: 20px 0;
        padding-left: 50px;
    }

    ol.list-group {
        min-height: 5px;
    }
</style>
<template>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">文章分类管理</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="none-item" v-if="items.length === 0">目前还没有分类哦！</div>
                    <ul class="list-group">
                        <li class="list-group-item clear-fix" v-for="item in items" :data-id="item.id">
                            <div class="list-group-item-content">
                                <em :style="{ background: item.background_color }"></em>
                                <span>{{ item.title }}</span>
                                <i class="handle"></i>
                                <button class="btn" @click="edit(item)"><i class="fa fa-fw fa-pencil"></i></button>
                            </div>
                            <ol class="list-group">
                                <li class="list-group-item clear-fix" v-for="sub in item.children" :data-id="sub.id">
                                    <div class="list-group-item-content">
                                        <em :style="{ background: sub.background_color }"></em>
                                        <span>{{ sub.title }}</span>
                                        <i class="handle"></i>
                                        <button class="btn" @click="edit(sub)"><i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                    </div>
                                    <ol class="list-group">
                                        <li class="list-group-item clear-fix" v-for="child in sub.children"
                                            :data-id="child.id">
                                            <div class="list-group-item-content">
                                                <em :style="{ background: child.background_color }"></em>
                                                <span>{{ child.title }}</span>
                                                <i class="handle"></i>
                                                <button class="btn" @click="edit(child)"><i
                                                        class="fa fa-fw fa-pencil"></i></button>
                                            </div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-primary" @click="create">创建分类</button>
        </div>
        <modal ref="modal">
            <div slot="title">
                <div class="modal-title">{{ modal.title }}</div>
            </div>
            <div slot="body">
                <div class="form-group">
                    <label>名称</label>
                    <input class="form-control" v-model="modal.name">
                </div>
                <div class="form-group">
                    <label>别名</label>
                    <input class="form-control" v-model="modal.alias">
                </div>
                <div class="form-group">
                    <label>内链</label>
                    <input class="form-control" v-model="modal.link">
                </div>
                <div class="form-group">
                    <label>描述</label>
                    <input class="form-control" v-model="modal.description">
                </div>
                <div class="form-group">
                    <label>颜色</label>
                    <input class="form-control" v-model="modal.background_color">
                </div>
                <div class="modal-footer clearfix">
                    <button class="btn btn-primary btn-submit" @click="submit">保存</button>
                    <button class="btn btn-delete" @click="remove">删除分类</button>
                </div>
            </div>
        </modal>
    </div>
</template>