/**
 * This JavaScript file must be present on every pages
 */

window.addEventListener("load", () => {
    const expiringDate = new Date(getToken().payload.expiry * 1000);
    if (expiringDate <= Date.now()) {
        addNotificationToast("Session expired", "Please <a href='/account.php'>log in</a>", expiringDate);
    }
});
