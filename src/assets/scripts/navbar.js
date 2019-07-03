$(document).ready(function () {
    let url_string = window.location.href
    let url = new URL(url_string);
    let page = url.searchParams.get("page");
    let detail = url.searchParams.get("detail");

    if (!page || page === "reporting") {
        $("#navbar-reporting").addClass("active");
    } else if (page === "errorpage") {
        $("#navbar-error").addClass("active");
    } else if (page === "component" && detail === "new") {
        $("#navbar-new-component").addClass("active");
    } else {
        $("#navbar-stammdaten").addClass("active");
    }
});