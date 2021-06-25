const pagination = () => ({

    currentPage: 0,
    maxPage: 0,
    displayedPages: 5,

    /**
     * Sets the maximum amount of elements, used to calculate the amount of pages
     * @param {number} max Maximum amount of elements
     */
    setElementCount: function(max) {

        const pageSize = getPage()?.pageSize || 20;
        this.maxPage = Math.ceil(max / pageSize);

        this.rebuildPagination();

    },

    /**
     * Builds a new li element to be added to the pagination
     * @private
     * @param {string} text Content of the element
     * @returns {HTMLLIElement}
     */
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

    /**
     * Rebuild the pagination element
     */
    rebuildPagination: function() {

        // Remove old page numbers
        while (this.element.children.length > 2)
            this.element.children[1].remove();

        // Build new page numbers
        const h = this.displayedPages / 2;
        const start = Math.max(0, this.currentPage - Math.floor(h));
        const end = Math.min(this.maxPage, this.currentPage + Math.ceil(h));

        // Get the previous and next elements
        const next = this.element.children[this.element.children.length - 1];
        const previous = this.element.children[0];

        if (this.currentPage === 0) previous.classList.add("disabled");
        else previous.classList.remove("disabled");

        if (this.currentPage === this.maxPage - 1) next.classList.add("disabled");
        else next.classList.remove("disabled");

        // Build the page li elements and insert before last li
        for (let i = start; i < end; i++) {
            const pageNumber = (Math.floor(i) + 1).toString();
            const li = this.buildPaginationLi(pageNumber);

            if (i === this.currentPage) {
                li.classList.add("active");
            }

            next.before(li);

            // Add on click listener to update the pagination element
            li.addEventListener("click", () => {
                this.currentPage = i;
                this.updatePagination();
            });
        }

    },

    /**
     * Rebuild pagination and call the callback with the new valies
     */
    updatePagination: function() {

        this.rebuildPagination();

        this.callback(...this.args, this.currentPage);

    },

    /**
     * Initialize pagination element
     * @param {HTMLUListElement} element Pagination element
     * @param {Function} callback Callback to call on update pagination
     * @param {...any} args Arguments to pass to the callback
     */
    plugPaginationElement: function(element, callback, ...args) {

        this.element = element;
        this.callback = callback;
        this.args = args;

        // Build pagination elements
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

        // Build li elements
        this.updatePagination();

    },

});