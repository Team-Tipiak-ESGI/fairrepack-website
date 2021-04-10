const referenceModel = {};

referenceModel.read = function () {
    return new Promise((resolve, reject) => {
        authenticatedFetch("/api/reference/read.php")
            .then(res => res.json())
            .then(json => {
                resolve(json);
            })
            .catch(err => {
                reject(err);
            });
    });
}