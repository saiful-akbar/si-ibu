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

        return rupiah ? rupiah : "";
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

    /**
     * Fungsi setting class pada table
     *
     * @memberof Main
     */
    tableClass() {
        const theme = $("meta[name=theme]").attr("content");

        $(".table").addClass("table-sm table-bordered");
        $("thead").removeClass("thead-light");

        if (theme.toLowerCase() === "light") {
            $("thead").addClass("thead-light");
        } else {
            $("thead").addClass("thead-dark");
        }
    }

    handleDelete(title, callback) {
        bootbox.confirm({
            title: title,
            message: String.raw`
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Peringatan!</h4>
                    <hr>
                    <div class="mb-0 ml-3">
                        <ul>
                            <li>Tindakan ini tidak dapat dibatalkan.</li>
                            <li>Data yang dihapus tidak dapat dikembalikan.</li>
                            <li>Berhati-hatilah dalam menghapus data.</li>
                        </ul>
                    </div>
                </div>
            `,
            buttons: {
                cancel: {
                    label: String.raw`<i class='mdi mdi-close'></i> Batal`,
                    className: "btn btn-sm btn-dark mr-2",
                },
                confirm: {
                    label: String.raw`<i class='mdi mdi-delete'></i> Hapus`,
                    className: "btn btn-danger btn-sm",
                },
            },
            callback: (response) => callback(response),
        });
    }
}

/**
 * inisialisasi class main
 */
const main = new Main();

/**
 * Waktu
 */
function dateTime() {
    setTimeout("dateTime()", 1000);

    const months = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "Mei",
        "Jun",
        "Jul",
        "Agus",
        "Sep",
        "Okt",
        "Nov",
        "Des",
    ];

    const days = [
        "00",
        "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "17",
        "18",
        "19",
        "20",
        "21",
        "22",
        "23",
        "24",
        "25",
        "26",
        "27",
        "28",
        "29",
        "30",
        "31",
    ];

    const minutes = [
        "00",
        "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "17",
        "18",
        "19",
        "20",
        "21",
        "22",
        "23",
        "24",
        "25",
        "26",
        "27",
        "28",
        "29",
        "30",
        "31",
        "32",
        "33",
        "34",
        "35",
        "36",
        "37",
        "38",
        "39",
        "40",
        "41",
        "42",
        "43",
        "44",
        "45",
        "46",
        "47",
        "48",
        "49",
        "50",
        "51",
        "52",
        "53",
        "54",
        "55",
        "56",
        "57",
        "58",
        "59",
        "60",
    ];

    const hours = [
        "00",
        "01",
        "02",
        "03",
        "04",
        "05",
        "06",
        "07",
        "08",
        "09",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "17",
        "18",
        "19",
        "20",
        "21",
        "22",
        "23",
        "24",
    ];

    const date = new Date();
    const year = date.getFullYear();
    const month = months[date.getMonth()];
    const day = days[date.getDate()];
    const hour = hours[date.getHours()];
    const minute = minutes[date.getMinutes()];
    const format = `${day} ${month} ${year}, ${hour}:${minute}`;

    $("#datetime").html(format);
}

/**
 * jalankan fungsi waktu
 */
window.setTimeout("dateTime()", 1000);

$(document).ready(function () {
    $("#scroll-to-top").click(function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: "smooth" });
    });
});
