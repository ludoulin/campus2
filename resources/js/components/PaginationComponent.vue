<template>
    <div>
        <nav aria-label="product-pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item" :class="pagination.current_page <= 1 ? 'disabled' : ''">
                    <a class="page-link" href="javascript:void(0)" @click.prevent="changePage(1)">第一頁</a>
                </li>
                <li class="page-item" :class="pagination.current_page <= 1 ? 'disabled' : ''">
                    <a class="page-link" href="javascript:void(0)" @click.prevent="changePage(pagination.current_page - 1)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item" v-for="page in pages" :key="page.index" :class="isCurrentPage(page) ? 'active' : ''">
                    <a class="page-link" href="javascript:void(0)" @click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="pagination.current_page >= pagination.last_page ? 'disabled' : ''">
                    <a class="page-link" href="javascript:void(0)" @click.prevent="changePage(pagination.current_page + 1)">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
                <li class="page-item" :class="pagination.current_page >= pagination.last_page ? 'disabled' : ''" aria-label="Next">
                    <a class="page-link" href="javascript:void(0)" @click.prevent="changePage(pagination.last_page)">最後一頁</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<style lang="scss" scoped>
    .pagination {
        margin-top: 40px;
    }
</style>

<script>
    export default {
        props: ['pagination', 'offset'],
        methods: {
            isCurrentPage(page) {
                return this.pagination.current_page === page;
            },
            changePage(page) {
                if (page > this.pagination.last_page) {
                    page = this.pagination.last_page;
                }
                this.pagination.current_page = page;
                this.$emit('paginate');
            }
        },
        computed: {
            pages() {
                let pages = [];
                let from = this.pagination.current_page - Math.floor(this.offset / 2);
                if (from < 1) {
                    from = 1;
                }
                let to = from + this.offset - 1;
                if (to > this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                while (from <= to) {
                    pages.push(from);
                    from++;
                }
                return pages;
            }
        }
    }
</script>