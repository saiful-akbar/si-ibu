/**
 * Class main
 * class untuk informasi global
 */
class Main {
    constructor() {
        this.baseUrl = $("meta[name=base-url]").attr("content");
        this.csrfToken = $("meta[name=csrf-token]").attr("content");
    }
}

/**
 * inisialisasi class main
 */
const main = new Main();
