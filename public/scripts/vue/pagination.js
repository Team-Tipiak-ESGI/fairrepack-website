const pagination = () => ({

    currentPage: 0,
    maxPage: 0,
    displayedPages: 5,

    setElementCount: function(max) {

        const pageSize = getPage()?.pageSize || 20;
        this.maxPage = Math.ceil(max / pageSize);

        this.rebuildPagination();

    },

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

    rebuildPagination: function() {

        // Remove old page numbers
        while (this.element.children.length > 2)
            this.element.children[1].remove();

        // Build new page numbers
        const h = this.displayedPages / 2;
        const start = Math.max(0, this.currentPage - Math.floor(h));
        const end = Math.min(this.maxPage, this.currentPage + Math.ceil(h));

        const next = this.element.children[this.element.children.length - 1];
        const previous = this.element.children[0];

        if (this.currentPage === 0) previous.classList.add("disabled");
        else previous.classList.remove("disabled");

        if (this.currentPage === this.maxPage - 1) next.classList.add("disabled");
        else next.classList.remove("disabled");

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

    },

    updatePagination: function() {

        this.rebuildPagination();

        this.callback(...this.args, this.currentPage);

    },

    plugPaginationElement: function(element, callback, ...args) {

        this.element = element;
        this.callback = callback;
        this.args = args;

        const previous = this.buildPaginationLi("<");
        const next = this.buildPaginationLi(">");

        previous.addEventListener("click", (e) => {
            if (e.target.classList.contains("disabled")) return;
            this.currentPage = Math.max(this.currentPage - 1, 0);
            this.updatePagination();
        });

        next.addEventListener("click", (e) => {
            if (e.target.classList.contains("disabled")) return;
            this.currentPage = Math.min(this.currentPage + 1, this.maxPage - 1);
            this.updatePagination();
        });

        this.element.prepend(previous);
        this.element.append(next);

        this.updatePagination();

    },

});