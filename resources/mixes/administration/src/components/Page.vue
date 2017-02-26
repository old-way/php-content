<script>
  import Core from '../main'
  export default {
    beforeCreate: function () {
      this.$options.components.Paginator = Core.instance.components.paginator
    },
    beforeRouteEnter (to, from, next) {
      Core.instance.store.commit('progress', 'start')
      Core.http.post(window.api + '/page/fetch').then(function (response) {
        let list = response.data.data
        let pagination = response.data.pagination
        Core.http.post(window.api + '/page/category/fetch', {
          'with-children': true
        }).then(function (response) {
          Core.instance.store.commit('progress', 'done')
          next((vm) => {
            vm.categories.all = response.data.data
            vm.categories.all.forEach(category => {
              category.parent_id === 0 && vm.categories.first.push(category)
            })
            vm.list = []
            list.forEach((page) => {
              page.checked = false
              vm.list.push(page)
            })
            vm.pagination = pagination
          })
        })
      }).catch(function (response) {
        Core.instance.store.commit('progress', 'fail')
      })
    },
    data () {
      return {
        categories: {
          all: [],
          first: [],
          id: 0,
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
          _this.$http.post(window.api + '/page/fetch', {
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
          _this.$http.post(window.api + '/page/fetch', {
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
      check: function (page) {
        page.checked = !page.checked
      },
      checkAll: function () {
        this.list.forEach((page) => {
          page.checked = true
        })
      },
      checkNone: function () {
        this.list.forEach((page) => {
          page.checked = !page.checked
        })
      },
      paginator: function (page) {
        let _this = this
        if (_this.categories.id === 'none') {
          _this.$http.post(window.api + '/page/fetch', {
            'only-no-category': true,
            page: page
          }).then(function (response) {
            _this.list = []
            response.data.data.map(function (page) {
              page.checked = false
              _this.list.push(page)
            })
            _this.pagination = response.data.pagination
          })
        } else {
          _this.$http.post(window.api + '/page/fetch', {
            category: _this.categories.id,
            page: page
          }).then(function (response) {
            _this.list = []
            response.data.data.map(function (page) {
              page.checked = false
              _this.list.push(page)
            })
            _this.pagination = response.data.pagination
          })
        }
      },
      remove: function (id) {
        let _this = this
        _this.$http.post(window.api + '/page/delete', {
          id: id
        }).then(function (response) {
          _this.list = []
          response.data.data.map(function (page) {
            page.checked = false
            _this.list.push(page)
          })
          _this.pagination = response.data.pagination
          _this.$store.commit('message', {
            show: true,
            type: 'notice',
            text: response.data.message
          })
        })
      },
      removeSelected: function () {
        let _this = this
        _this.list.forEach((page) => {
          if (page.checked) {
            _this.$http.post(window.api + '/page/delete', {
              id: page.id
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
            })
          }
        })
      },
      search: function () {
        let _this = this
        if (_this.keyword.length > 0) {
          _this.$http.post(window.api + '/page/fetch', {
            search: _this.keyword
          }).then(function (response) {
            console.log(response)
            _this.list = []
            response.data.data.forEach((article) => {
              article.checked = false
              _this.list.push(article)
            })
            _this.pagination = response.data.pagination
          })
        } else {
          window.alert('请输入搜索关键字！')
        }
      },
      submit: function (e) {
        this.$validator.validateAll()
        if (this.errors.any()) {
          return false
        }
      }
    },
    mounted () {
      this.$store.commit('title', '全部页面 - 页面 - Notadd Administration')
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

    .box-body > .table > tbody > tr > td:last-child > .btn-danger:hover,
    .box-header > .box-extend > .btn-danger:hover {
        background-color: #ef5151;
        border-color: #ef5151;
        color: #ffffff;
    }

    .pagination > li > a {
        background: transparent;
        border-color: transparent;
        margin: 0 5px;
    }

    .pagination > li:first-child > a,
    .pagination > li:last-child > a {
        border-color: #cccccc;
        border-radius: 6px;
        color: #cccccc;
    }

    .pagination > li:first-child > a {
        margin-left: 0;
    }

    .pagination > li:last-child > a {
        margin-right: 0;
    }

    .pagination > li > a:hover,
    .pagination > li.active > a {
        background: #3498db;
        border-color: #3498db;
        border-radius: 6px;
        color: #ffffff;
        margin-bottom: 1px;
        margin-top: 1px;
        padding-bottom: 5px;
        padding-top: 5px;
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
                <router-link to="/content/page/create" class="btn btn-primary btn-create">添加页面</router-link>
                <button class="btn btn-primary" @click="checkAll">全选</button>
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
                    <tr v-for="page in list">
                        <td :class="{ checked: page.checked }" @click="check(page)">{{ page.title }}</td>
                        <td></td>
                        <td>{{ page.created_at }}</td>
                        <td>
                            <button class="btn btn-primary btn-sm">查看</button>
                            <router-link class="btn btn-info btn-sm" :to="'/content/page/' + page.id + '/edit'">编辑</router-link>
                            <button class="btn btn-danger btn-sm" @click="remove(page.id)">删除</button>
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