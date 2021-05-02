const cartController = {};

cartController.add = function(reference_id) {
    const currentCard = this.get();

    authenticatedFetch(`/api/reference/read.php?id=${reference_id}`)
        .then(res => res.json())
        .then(json => {
            const reference = json.items;

            if (currentCard[reference_id] === undefined) {
                delete reference.id;
                currentCard[reference_id] = reference;
                currentCard[reference_id].count = 0;
            }

            currentCard[reference_id].count++;

            window.localStorage.setItem("cartController", JSON.stringify(currentCard));
        });
}

cartController.get = function() {
    return JSON.parse(window.localStorage.getItem("cartController") || "{}");
}

cartController.getTotal = function() {
    return Object.values(this.get()).reduce((p, c) => p + c);
}