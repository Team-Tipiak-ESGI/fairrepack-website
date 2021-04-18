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
    const headers = JSON.parse(atob(token.split('.')[0]));
    const payload = JSON.parse(atob(token.split('.')[1]));

    return {
        token: token,
        headers: headers,
        payload: payload,
    };
};

/**
 * Converts a FormData object to JSON string
 * @param {FormData} formData
 * @returns {string} JSON string
 */
function formDataToJSON(formData) {
    const entriesArray = Array.from(formData.entries());
    const entries = {};

    for (const entry of entriesArray) {
        entries[entry[0]] = entry[1];
    }

    return JSON.stringify(entries);
}

Date.prototype.format = function (format) {
    const associations = {"%yyyy": "getFullYear", "%dd": "getDay", "%hh": "getHours", "%mmmm": "getMilliseconds", "%mm": "getMinutes", "%MM": "getMonth", "%ss": "getSeconds" }

    for (const match of format.match(/(?<!%)%(?!%)(\w*)/g)) {
        let value = this[associations[match]]?.call(this);
        format = format.replace(match, (match === "%MM" ? ++value : value)?.toString().padStart(match.length - 1, '0') ?? match);
    }

    return format;
};

function getPageId() {
    return new URLSearchParams(window.location.search.substr(1)).get('id');
}