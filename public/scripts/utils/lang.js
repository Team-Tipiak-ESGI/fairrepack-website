/**
 * @type {(function(*, ...[*]): (*|string))|*}
 */
const i18n = (() => {
    // Get website language
    const available_languages = ["fr", "en"];
    const default_language = "en";
    let lang = window.localStorage.getItem("lang");

    if (lang === null)
        window.localStorage.setItem("lang", navigator.language.split("-")[0]);

    if (!available_languages.includes(lang))
        lang = default_language;

    // Make a request to get all the languages
    const languages = JSON.parse(window.localStorage.getItem("languages") || "{}");
    const promises = [];
    for (const l of available_languages) {
        promises.push(fetch(`/trad/${l}.json`)
            .then(res => res.json()));
    }

    // Wait until all requests are done
    Promise.all(promises)
        .then(json => {
            // Loop into the responses and add them to the languages variable
            for (let i = 0; i < json.length; i++) {
                languages[available_languages[i]] = json[i];
            }

            // Add languages to the browser's cache
            window.localStorage.setItem("languages", JSON.stringify(languages));

            // Add a listener to translate the page, if the page has not finished loaded yet
            window.addEventListener("load", translatePage);
            translatePage(); // Translate pages automatically
        })
        .catch(err => console.error(err));

    return (msg, ...params) => {
        // Split the message name into keys
        msg = msg.split(/\./g);
        let translation = languages[lang];

        for (const element of msg) {
            translation = translation?.[element];
        }

        // If no parameters are provided, return the translation as is
        if (params.length === 0) return translation;

        // Match all parameters in the form of $<number>
        const iter = translation.matchAll(/\$(\d+)/g);
        let match, i = 0;

        // Loop through all parameters and replace them
        while (!(match = iter.next()).done)
            translation = translation.replace(match.value[0], params[i++]);

        return translation;
    };
})();

/**
 * Loop into all the data-i18n elements and translates them
 */
function translatePage() {
    // Replace messages
    const nodes = document.querySelectorAll("[data-i18n]");
    for (const node of nodes) {
        node.innerText = i18n(node.innerHTML);
        node.removeAttribute("data-i18n");
    }
}

function changeLanguage(lang) {
    window.localStorage.setItem("lang", lang);
}
