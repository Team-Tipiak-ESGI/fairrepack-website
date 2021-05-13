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
 * Return Token
 * @type {function(): {headers: {alg: string, typ: string}, payload: {expiry: number, lang: string, type: string, username: string, uuid: string}, token: string}}
 */
const getToken = () => {
    const token = window.localStorage.getItem('token');
    if (token === null) return null;

    const headers = JSON.parse(atob(token.split('.')[0]));
    const payload = JSON.parse(atob(token.split('.')[1]));

    return {
        token: token,
        headers: headers,
        payload: payload,
    };
};

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

    for (const entry of entriesArray) {
        let value = entry[1];
        const previous_value = entries[entry[0]];

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
 * @returns {{pageId: string, pageSize: number, pageNumber: number, urlParams: string}}
 */
function getPage(pageNumber = 0) {
    const pageId = new URLSearchParams(window.location.search.substr(1)).get('id');
    const pageSize = parseInt(window.localStorage.getItem("pageSize")) || 20;
    const urlParams = `page=${pageNumber}&limit=${pageSize}`;

    return {
        pageId: pageId,
        pageSize: pageSize,
        pageNumber: pageNumber,
        urlParams: urlParams,
    };
}

function between(value, min, max) {
    return Math.min(Math.max(value, min), max);
}

function addNotificationToast(title, content = '', date = new Date()) {
    const toastContainer = document.getElementById('toastContainer');

    const toast = document.createElement('div');

    toast.classList.add('toast', 'show');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    toast.innerHTML = `<div class="toast-header">
          <!--<img src="..." class="rounded me-2" alt="...">-->
          <strong class="me-auto">${title}</strong>
          <small class="text-muted">now</small>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">${content}</div>`

    new bootstrap.Toast(toast);

    if (typeof date === "string") date = new Date(date);

    const minutes = Math.floor((Date.now() - date.getTime()) / (60 * 1000));
    const timeNotice = toast.querySelector('small');
    timeNotice.innerText = `${minutes} minutes ago`;

    const interval = setInterval(() => {
        const minutes = Math.floor((Date.now() - date.getTime()) / (60 * 1000));
        timeNotice.innerText = `${minutes} minutes ago`;
    }, 1000 * 60);

    toast.addEventListener('hidden.bs.toast', function () {
        clearInterval(interval);
    });

    toastContainer.append(toast);
}
