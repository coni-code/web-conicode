export function getLocale() {
    const html = document.querySelector('html');
    const {locale} = html.dataset;

    if (!locale) {
        throw new Error('94a6ced9-7ba9-440c-baac-8e681448085b');
    }

    return locale;
}
