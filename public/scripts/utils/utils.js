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