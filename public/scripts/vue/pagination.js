const pagination = () => ({

    currentPage: 0,
    maxPage: 10,
    displayedPages: 5,

    buildPaginationLi: function(text) {
        const li = document.createElement(`li`);
        li.classList.add(`page-item`);
        const span = document.createElement(`span`);
        span.classList.add(`page-link`);
        li.append(span);
        span.innerText = text;
        li.style.cursor = "pointer";
        li.style.userSelect = "none";
        return li;
    },

    updatePagination: function() {

        // Remove old page numbers
        while (this.element.children.length > 2)
            this.element.children[1].remove();

        // Build new page numbers
        const h = this.displayedPages / 2;
        const start = Math.max(0, this.currentPage - Math.floor(h));
        const end = Math.min(this.maxPage, this.currentPage + Math.ceil(h));

        const next = this.element.children[this.element.children.length - 1];

        for (let i = start; i < end; i++) {
            const pageNumber = (Math.floor(i) + 1).toString();
            const li = this.buildPaginationLi(pageNumber);

            if (i === this.currentPage) {
                li.classList.add("active");
            }

            next.before(li);

            li.addEventListener("click", () => {
                this.currentPage = i;
                this.updatePagination();
            });
        }

        this.callback(...this.args, this.currentPage);

    },

    plugPaginationElement: function(element, callback, ...args) {
        this.element = element;
        this.callback = callback;
        this.args = args;

        const previous = this.buildPaginationLi("<");
        const next = this.buildPaginationLi(">");

        previous.addEventListener("click", () => {
            this.currentPage = Math.max(this.currentPage - 1, 0);
            this.updatePagination();
        });

        next.addEventListener("click", () => {
            this.currentPage = Math.min(this.currentPage + 1, this.maxPage - 1);
            this.updatePagination();
        });

        this.element.prepend(previous);
        this.element.append(next);

        this.updatePagination();
    },

});