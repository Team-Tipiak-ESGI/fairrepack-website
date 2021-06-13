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

    // Get languages
    const languages = JSON.parse(window.localStorage.getItem("languages") || "{}");
    const promises = [];
    for (const l of available_languages) {
        promises.push(fetch(`/trad/${l}.json`)
            .then(res => res.json()));
    }

    Promise.all(promises)
        .then(json => {
            for (let i = 0; i < json.length; i++) {
                languages[available_languages[i]] = json[i];
            }
            window.localStorage.setItem("languages", JSON.stringify(languages));
            translatePage();
        })
        .catch(err => console.error(err));

    return (msg, ...params) => {
        msg = msg.split(/\./g);
        let translation = languages[lang];
        for (const element of msg) {
            translation = translation?.[element];
        }
        if (params.length === 0) return translation;

        const iter = translation.matchAll(/\$(\d+)/g);
        let match, i = 0;

        while (!(match = iter.next()).done)
            translation = translation.replace(match.value[0], params[i++]);

        return translation;
    };
})();

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
