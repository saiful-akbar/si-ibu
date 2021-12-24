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
     * @returns string
     */
    formatRupiah() {
        let numberString = angka.toString().replace(/[^,\d]/g, "");
        let split = numberString.split(",");
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return rupiah ? `Rp. ${rupiah}` : "";
    }
}

/**
 * inisialisasi class main
 */
const main = new Main();
