/**
 * Make an authenticated request to the server using the token in localStorage
 * @param url Request URL
 * @param method Request method
 * @param body Request body, as JSON string
 * @returns {Promise<*>}
 */
function authenticatedFetch(url, method = 'GET', body = undefined) {
    const token = window.localStorage.getItem('token');

    return fetch(url, {
        method: method,
        headers: {
            'Authorization': `Bearer ${token}`,
        },
        body: body,
    })
        .then(res => {
            if (200 <= res.status && res.status < 300) {
                return res;
            } else {
                throw res;
            }
        });
}

/**
 * Return the user's token
 * @type {function(): {headers: {alg: string, typ: string}|null, payload: {expiry: number, lang: string, type: string, username: string, uuid: string}|null, token: string|null, valid: boolean}}
 */
const getToken = () => {
    const token = window.localStorage.getItem('token');

    if (token === null) {
        return {
            token: null,
            headers: null,
            payload: null,
            valid: false,
        };
    }

    // Decode token's headers and payload
    const headers = JSON.parse(atob(token?.split('.')[0]));
    const payload = JSON.parse(atob(token?.split('.')[1]));

    // Verify expiring date
    const valid = payload.expiry * 1000 > Date.now();

    return {
        token: token,
        headers: headers,
        payload: payload,
        valid: valid,
    };
};

/**
 * Converts a File to a base 64 string, useful to send file in json
 * @param {File|Blob} file
 * @returns {Promise<string>}
 */
const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

/**
 * Converts a FormData object to JSON string
 * @param {FormData} formData
 * @returns {string} JSON string
 */
async function formDataToJSON(formData) {
    const entriesArray = Array.from(formData.entries());
    const entries = {};

    // Construct json object
    for (const entry of entriesArray) {
        let value = entry[1];
        const previous_value = entries[entry[0]];

        // If the value is a file, convert it
        if (value instanceof File)
            value = await toBase64(value);

        if (previous_value === undefined)
            entries[entry[0]] = value;
        else {
            if (!(previous_value instanceof Array))
                entries[entry[0]] = [previous_value];
            entries[entry[0]].push(value);
        }
    }

    return JSON.stringify(entries);
}

/**
 * Format a date to a given format
 * @param format
 * @returns {string}
 */
Date.prototype.format = function (format) {
    const associations = {"%yyyy": "getFullYear", "%dd": "getDate", "%hh": "getHours", "%mmmm": "getMilliseconds", "%mm": "getMinutes", "%MM": "getMonth", "%ss": "getSeconds" }

    for (const match of format.match(/(?<!%)%(?!%)(\w*)/g)) {
        let value = this[associations[match]]?.call(this);
        format = format.replace(match, (match === "%MM" ? ++value : value)?.toString().padStart(match.length - 1, '0') ?? match);
    }

    return format;
};

/**
 * Get page ID from url
 * @deprecated Use getPage().pageId function instead
 * @returns {string} Page's ID
 */
function getPageId() {
    return new URLSearchParams(window.location.search.substr(1)).get('id');
}

/**
 * Return information about the page
 * @param {number|undefined} pageNumber
 * @returns {{pageId: string, pageSize: number, pageNumber: number, urlParams: string, search: string, setPageInput: function}}
 */
function getPage(pageNumber = 0) {
    // Get url parameters
    const urlSearchParams = new URLSearchParams(window.location.search.substr(1));
    const pageId = urlSearchParams.get('id');
    const search = urlSearchParams.get('search');

    // Get page size
    const pageSize = parseInt(window.localStorage.getItem("pageSize")) || 20;
    let urlParams = `page=${pageNumber}&limit=${pageSize}`; // Pre-construct request params

    if (search)
        urlParams += `&search=${search}`;

    return {
        pageId: pageId,
        pageSize: pageSize,
        pageNumber: pageNumber,
        urlParams: urlParams,
        search: search,
        /**
         * Create an event to change page size from a select element
         * @param {HTMLSelectElement} input
         */
        setPageInput: (input) => {
            input.value = pageSize.toString();
            input.addEventListener("change", (e) => {
                window.localStorage.setItem("pageSize", e.target.value);
                window?.nav.updatePagination();
            });
        },
    };
}

/**
 * Forces a value to be between 2 other values
 * @param {number} value
 * @param {number} min Minimum value
 * @param {number} max Maximum value
 * @returns {number}
 */
function between(value, min, max) {
    return Math.min(Math.max(value, min), max);
}

/**
 * Build a bootstrap toast component
 * @param {string} title Title of the toast
 * @param {string|HTMLElement} c Content of the toast, can be an HTML element or a string
 * @returns {HTMLDivElement} The newly created toast
 */
function buildToast(title, c) {
    let content = c;
    if (typeof c === "string") {
        content = document.createElement("div");
        content.innerHTML = c;
    }

    const div_1 = document.createElement(`div`);
    div_1.classList.add(`toast`, `show`);
    div_1.setAttribute(`role`, `alert`);
    div_1.setAttribute(`aria-live`, `assertive`);
    div_1.setAttribute(`aria-atomic`, `true`);
    const div_c = document.createElement(`div`);
    div_c.classList.add(`toast-header`);
    const strong_3e = document.createElement(`strong`);
    strong_3e.classList.add(`me-auto`);

    div_c.append(strong_3e);
    strong_3e.innerText = title;
    const small_3g = document.createElement(`small`);
    small_3g.classList.add(`text-muted`);

    div_c.append(small_3g);
    small_3g.innerText = `now`;
    const button_3i = document.createElement(`button`);
    button_3i.type = `button`;
    button_3i.classList.add(`btn-close`);
    button_3i.setAttribute(`data-bs-dismiss`, `toast`);
    button_3i.setAttribute(`aria-label`, `Close`);

    div_c.append(button_3i);

    div_1.append(div_c);
    const div_e = document.createElement(`div`);
    div_e.classList.add(`toast-body`);

    div_1.append(div_e);
    div_e.append(content);

    return div_1;
}

/**
 * Creates and adds a toast to the top right of the website's window
 * @param title
 * @param content
 * @param date
 * @returns {HTMLDivElement}
 */
function addNotificationToast(title, content = '', date = new Date()) {
    const toastContainer = document.getElementById('toastContainer');

    // Creates and instantiate the toast
    const toast = buildToast(title, content);
    new bootstrap.Toast(toast);

    if (typeof date === "string") date = new Date(date);

    const minutes = Math.floor((Date.now() - date.getTime()) / (60 * 1000));
    const timeNotice = toast.querySelector('small');
    timeNotice.innerText = `Just now`;

    // Create an interval to update the time
    const interval = setInterval(() => {
        const minutes = Math.floor((Date.now() - date.getTime()) / (60 * 1000));
        if (minutes === 0)
            timeNotice.innerText = `Just now`;
        else
            timeNotice.innerText = `${minutes} minutes ago`;
    }, 1000 * 60);

    // On toast hidden
    toast.addEventListener('hidden.bs.toast', function () {
        clearInterval(interval); // Clear the interval for performance
    });

    toastContainer.append(toast);

    return toast;
}

/**
 * Add a Bootstrap spinner to the given button
 * @param {HTMLButtonElement} button
 * @returns {Function} Function to reset to the previous state
 */
function buttonSpinner(button) {
    const span = document.createElement('span');
    span.classList.add('spinner-border', 'spinner-border-sm');
    span.setAttribute('role', 'status');
    span.setAttribute('aria-hidden', 'true');
    button.prepend(span);
    button.disabled = true;

    return () => (span.remove(), button.disabled = false);
}
