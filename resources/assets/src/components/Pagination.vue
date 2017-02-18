<template>
  <transition name="fade">
    <ul v-if="!hide" class="pagination">
      <li ref="prev"><a @click.prevent="prev">&laquo;</a></li>
      <li ref="page" v-for="item in pageList"><a @click="page(item)">{{ item }}</a></li>
      <li ref="next"><a @click.prevent="next">&raquo;</a></li>
    </ul>
  </transition>
</template>
<script>
  export default {
    props: {
      url: String,
      startPage: {
        type: Number,
        default: 1
      },
      limit: {
        type: Number,
        default: 10
      }
    },
    data: () => ({
      hide: false,
      sync: false,
      perPage: 0,
      currentPage: 0,
      nextPageUrl: null,
      prevPageUrl: null,
      from: 0,
      to: 0,
      data: [],
      total: 0,
      lastPage: 0,

      pageList: []
    }),
    created () {
      this.currentPage = this.startPage
    },
    mounted () {
      this.page(this.currentPage)
    },
    methods: {
      lock () {
        if (this.sync) return true
        this.sync = !this.sync
        return false
      },
      unlock () {
        if (!this.sync) return true
        this.sync = !this.sync
        return false
      },
      page (index, success) {
        if (this.lock()) return
        this.$http.get(`${this.url}?page=${index}`).then((response) => {
          if (response.status === 200) {
            const data = response.data
            this.perPage = data.data.per_page
            this.currentPage = data.data.current_page
            this.nextPageUrl = data.data.next_page_url
            this.prevPageUrl = data.data.prev_page_url
            this.from = data.data.from
            this.to = data.data.to
            this.total = data.data.total
            this.lastPage = data.data.last_page
            this.data = data.data.data
            this.pageList = []

            if (this.total < this.perPage) {
              this.hide = true
            } else {
              this.hide = false
            }

            const SKIP = 5
            let active = 0
            for (let i = 1; i <= SKIP * 2 && i <= this.lastPage; i += 1) {
              if (this.currentPage <= SKIP && i <= this.lastPage) {
                this.pageList.push(i)
                if (i === this.currentPage) {
                  active = i - 1
                }
              } else if (
                (this.currentPage - SKIP) + i <= this.lastPage && (this.currentPage - SKIP) + i >= 1
              ) {
                this.pageList.push((this.currentPage - SKIP) + i)
                if ((this.currentPage - SKIP) + i === this.currentPage) {
                  active = i - 1
                }
              }
            }

            this.$nextTick(() => {
              if (this.$refs.page !== undefined) {
                for (const dom of this.$refs.page) {
                  dom.className = ''
                }
                if (this.$refs.page[active] !== undefined) {
                  this.$refs.page[active].className = 'active'
                }
              }
            })

            this.$emit('change', data.data.data, this.currentPage, data.data.last_page)

            if (this.currentPage > this.lastPage && this.lastPage !== 0) {
              this.currentPage = this.lastPage
              this.unlock()
              this.page(this.currentPage, () => {
                this.unlock()
              })
              return
            }

            if ((this.currentPage - 1) < 1) {
              this.$refs.prev.className = 'disabled'
            } else {
              this.$refs.prev.className = ''
            }

            if (data.data.to !== data.data.total && data.data.total !== 0) {
              this.$refs.next.className = ''
            } else {
              this.$refs.next.className = 'disabled'
            }

            if (success !== undefined) {
              success()
            }
          }
          this.unlock()
        }, () => {
          this.unlock()
        })
      },
      prev () {
        if (this.$refs.prev.className === 'disabled') return
        this.page(this.currentPage - 1)
      },
      next () {
        if (this.$refs.next.className === 'disabled') return
        this.page(this.currentPage + 1)
      }
    }
  }
</script>
