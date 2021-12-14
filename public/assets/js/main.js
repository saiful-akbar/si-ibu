class App {
    constructor() {
        this.baseUrl = $("meta[name=base-url]").attr("content");
        this.csrfToken = $("meta[name=csrf-token]").attr("content");
    }
}
