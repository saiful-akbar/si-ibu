/**
 * Class main
 * class untuk informasi global
 */
class Main {
    constructor() {
        this.baseUrl = $("meta[name=base-url]").attr("content");
        this.csrfToken = $("meta[name=csrf-token]").attr("content");
    }

    /**
     * Method untuk membuat format rupiah
     *
     * @returns int
     */
    formatRupiah(nominal) {
        let numberString = nominal.toString().replace(/[^,\d]/g, "");
        let split = numberString.split(",");
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            let separator = sisa ? "." : "";

            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah ? `Rp. ${rupiah}` : "";
    }

    /**
     * Fungsi format kilo untuk mata uang
     *
     * @param {int} nominal
     * @returns string
     */
    formatKilo(nominal) {
        const kilo = nominal / 1000;

        let numberString = kilo.toString().replace(/[^,\d]/g, "");
        let split = numberString.split(",");
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            let separator = sisa ? "." : "";

            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah ? `${rupiah}k` : "";
    }
}

/**
 * inisialisasi class main
 */
const main = new Main();

$(document).ready(function () {
    $("#scroll-to-top").click(function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});
