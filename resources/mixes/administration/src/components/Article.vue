<script>
  import Core from '../main'
  export default {
    beforeCreate: function () {
      this.$options.components.Paginator = Core.instance.components.paginator
    },
    beforeRouteEnter (to, from, next) {
      Core.instance.store.commit('progress', 'start')
      Core.http.post(window.api + '/article/fetch').then(function (response) {
        let list = response.data.data
        let pagination = response.data.pagination
        Core.http.post(window.api + '/category/fetch', {
          'with-children': true
        }).then(function (response) {
          Core.instance.store.commit('progress', 'done')
          next((vm) => {
            vm.categories.all = response.data.data
            vm.categories.all.forEach(category => {
              category.parent_id === 0 && vm.categories.first.push(category)
            })
            vm.list = []
            list.forEach((article) => {
              article.checked = false
              vm.list.push(article)
            })
            vm.pagination = pagination
          })
        })
      }).catch(() => {
        Core.instance.store.commit('progress', 'fail')
      })
    },
    data () {
      return {
        categories: {
          all: [],
          first: [],
          id: 0,
          none: false,
          selected: {
            first: 0,
            second: 0,
            third: 0
          },
          second: [],
          third: []
        },
        keyword: '',
        list: [],
        pagination: {
          last_page: 1
        }
      }
    },
    methods: {
      categorySelected: function (level, event) {
        let _this = this
        let category
        _this.categories.id = event.target.value
        if (_this.categories.id === '0') {
          switch (level) {
            case 'first':
              _this.categories.second = []
              _this.categories.third = []
              break
            case 'second':
              _this.categories.third = []
              _this.categories.id = _this.categories.selected.first
              break
            case 'third':
              _this.categories.id = _this.categories.selected.second
              break
          }
        } else {
          switch (level) {
            case 'first':
              if (_this.categories.id === 'none') {
                _this.categories.second = []
                _this.categories.third = []
              } else {
                category = find()
                _this.categories.second = category.hasOwnProperty('children') ? category.children : []
                _this.categories.third = []
                _this.categories.selected.first = _this.categories.id
              }
              break
            case 'second':
              category = find()
              _this.categories.third = category.hasOwnProperty('children') ? category.children : []
              _this.categories.selected.second = _this.categories.id
              break
            case 'third':
              _this.categories.selected.third = _this.categories.id
              break
          }
        }
        if (_this.categories.id === 'none') {
          _this.$http.post(window.api + '/article/fetch', {
            'only-no-category': true
          }).then(response => {
            _this.list = []
            response.data.data.forEach((article) => {
              article.checked = false
              _this.list.push(article)
            })
            _this.pagination = response.data.pagination
          })
        } else {
          _this.$http.post(window.api + '/article/fetch', {
            category: _this.categories.id
          }).then(response => {
            _this.list = []
            response.data.data.forEach((article) => {
              article.checked = false
              _this.list.push(article)
            })
            _this.pagination = response.data.pagination
          })
        }
        function find () {
          let _selected
          _this.categories.all.forEach(function (cateogry) {
            if (cateogry.id.toString() === _this.categories.id.toString()) {
              _selected = cateogry
            }
          })
          return _selected
        }
      },
      check: function (article) {
        article.checked = !article.checked
      },
      checkNone: function () {
        this.list.forEach((article) => {
          article.checked = !article.checked
        })
      },
      paginator: function (page) {
        let _this = this
        if (_this.categories.id === 'none') {
          _this.$http.post(window.api + '/article/fetch', {
            'only-no-category': true,
            page: page
          }).then(response => {
            _this.list = []
            response.data.data.forEach((article) => {
              article.checked = false
              _this.list.push(article)
            })
            _this.pagination = response.data.pagination
          })
        } else {
          _this.$http.post(window.api + '/article/fetch', {
            category: _this.categories.id,
            page: page
          }).then(function (response) {
            _this.list = []
            response.data.data.map(function (article) {
              article.checked = false
              _this.list.push(article)
            })
            _this.pagination = response.data.pagination
          })
        }
      },
      remove: function (id) {
        let _this = this
        _this.$http.post(window.api + '/article/delete', {
          id: id
        }).then(function (response) {
          _this.list = []
          response.data.data.map(function (article) {
            article.checked = false
            _this.list.push(article)
          })
          _this.pagination = response.data.pagination
          _this.$store.commit('message', {
            show: true,
            type: 'notice',
            text: response.data.message
          })
        }, function (response) {
          console.log(response)
        })
      },
      removeSelected: function () {
        let _this = this
        _this.list.forEach((article) => {
          if (article.checked) {
            _this.$http.post(window.api + '/article/delete', {
              id: article.id
            }).then(function (response) {
              _this.list = []
              response.data.data.map(function (article) {
                article.checked = false
                _this.list.push(article)
              })
              _this.pagination = response.data.pagination
              _this.$store.commit('message', {
                show: true,
                type: 'notice',
                text: '批量删除成功！'
              })
            }, function (response) {
              console.log(response)
            })
          }
        })
      },
      search: function () {
        let _this = this
        if (_this.keyword.length > 0) {
          _this.$http.post(window.api + '/article/fetch', {
            search: _this.keyword
          }).then(function (response) {
            console.log(response)
            _this.list = []
            response.data.data.forEach((article) => {
              article.checked = false
              _this.list.push(article)
            })
            _this.pagination = response.data.pagination
          }).catch(error => {
            console.log(error)
          })
        } else {
          window.alert('请输入搜索关键字！')
        }
      },
      submit: function (e) {
        let _this = this
        _this.$validator.validateAll()
        if (_this.errors.any()) {
          return false
        }
      }
    },
    mounted () {
      this.$store.commit('title', '全部文章 - 文章 - Notadd Administration')
    }
  }
</script>
<style scoped>
    .box {
        border-top: none;
        padding-left: 40px;
        padding-right: 40px;
    }

    .box-body {
        border-bottom: 1px solid #eeeeee;
        border-radius: 0;
        border-top: 1px solid #eeeeee;
    }

    .box-body > .table > tbody > tr > td {
        border-color: #eeeeee;
        height: 60px;
        vertical-align: middle;
    }

    .box-body > .table > tbody > tr > td:last-child {
        letter-spacing: 6px;
        text-align: right;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn {
        border-radius: 4px;
        letter-spacing: 0;
        padding: 5px 12px;
    }

    .box-footer {
        text-align: right;
    }

    .box-footer,
    .box-header {
        height: 80px;
        padding: 23px 0;
        position: relative;
    }

    .box-header > .box-search {
        float: left;
        width: 320px;
    }

    .box-header > .box-search > .form-control {
        border-bottom-left-radius: 18px;
        border-color: #cccccc;
        border-right-width: 0;
        border-top-left-radius: 18px;
    }

    .box-header > .box-search > .input-group-btn {
        border: 1px solid #cccccc;
        border-bottom-right-radius: 18px;
        border-left-width: 0;
        border-top-right-radius: 18px;
        overflow: hidden;
    }

    .box-header > .box-search > .input-group-btn > .btn {
        padding-bottom: 6px;
        padding-top: 6px;
        width: 60px;
    }

    .box-header > .box-extend {
        letter-spacing: 16px;
        text-align: right;
    }

    .box-header > .box-extend > .btn {
        border-radius: 6px;
        padding: 6px 32px;
    }

    .box-header > .box-extend > .form-control {
        display: inline-block;
        vertical-align: middle;
        width: 140px;
    }

    .box-body > .table > tbody > tr > td:first-child {
        background: url("../../static/images/unselected.svg") 10px center no-repeat;
        padding-left: 50px;
    }

    .box-body > .table > tbody > tr > td:first-child.checked {
        background: url("../../static/images/selected.svg") 10px center no-repeat;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn,
    .box-header > .box-extend > .btn {
        background: #ffffff;
        border-width: 1px;
        color: #000000;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-primary,
    .box-header > .box-extend > .btn-primary {
        border-color: #3498db;
        color: #3498db;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-primary:hover,
    .box-header > .box-extend > .btn-primary:hover {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-info,
    .box-header > .box-extend > .btn-info {
        border-color: #8ba0ca;
        color: #8ba0ca;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-info:hover,
    .box-header > .box-extend > .btn-info:hover {
        background-color: #8ba0ca;
        border-color: #8ba0ca;
        color: #ffffff;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-danger,
    .box-header > .box-extend > .btn-danger {
        border-color: #ef5151;
        color: #ef5151;
    }

    .box-body > .table > tbody > tr > td:last-child > .btn-danger:hover,
    .box-header > .box-extend > .btn-danger:hover {
        background-color: #ef5151;
        border-color: #ef5151;
        color: #ffffff;
    }

    .box-header > .box-extend > .btn {
        letter-spacing: 0;
    }

    .box-header > .box-extend > .btn-create {
        background: #3498db;
        color: #ffffff;
        letter-spacing: 0;
    }

    .box-header > .box-extend > .btn-create:hover {
        background: #258cd1;
    }

    .box-header > .box-extend > .btn-create:active,
    .box-header > .box-extend > .btn-create:focus {
        background: #2b7cb3;
    }
</style>
<template>
    <div class="box">
        <div class="box-header">
            <div class="box-search input-group">
                <input class="form-control pull-right" placeholder="请输入搜索关键字" v-model="keyword" type="text">
                <div class="input-group-btn">
                    <button class="btn btn-primary" @click="search">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="box-extend">
                <select class="form-control" v-if="categories.first.length !== 0" @change="categorySelected('first', $event)">
                    <option value="0">选择分类</option>
                    <option value="none">未分类</option>
                    <option v-for="category in categories.first" :value="category.id">{{ category.title }}</option>
                </select>
                <select class="form-control" v-if="categories.second.length !== 0" @change="categorySelected('second', $event)">
                    <option value="0">选择分类</option>
                    <option v-for="category in categories.second" :value="category.id">{{ category.title }}</option>
                </select>
                <select class="form-control" v-if="categories.third.length !== 0" @change="categorySelected('third', $event)">
                    <option value="0">选择分类</option>
                    <option v-for="category in categories.third" :value="category.id">{{ category.title }}</option>
                </select>
                <router-link to="/content/article/create" class="btn btn-primary btn-create">添加文章</router-link>
                <button class="btn btn-primary" @click="checkNone">反选</button>
                <button class="btn btn-danger" @click="removeSelected">删除</button>
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <colgroup>
                    <col class="col-md-6">
                    <col class="col-md-2">
                    <col class="col-md-2">
                    <col class="col-md-2">
                </colgroup>
                <tbody>
                <tr v-for="article in list">
                    <td :class="{ checked: article.checked }" @click="check(article)">{{ article.title }}</td>
                    <td>{{ article.category }}</td>
                    <td>{{ article.created_at }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm">查看</button>
                        <router-link :to="'/content/article/' + article.id + '/edit'" class="btn btn-info btn-sm">编辑
                        </router-link>
                        <button class="btn btn-danger btn-sm" @click="remove(article.id)">删除</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <paginator :pageCount="pagination.last_page"
                       :pageRange="3"
                       :marginPages="2"
                       :clickHandler="paginator"
                       prevText="上一页"
                       nextText="下一页"
                       containerClass="pagination no-margin"
                       pageClass="'page-item'">
            </paginator>
        </div>
    </div>
</template>