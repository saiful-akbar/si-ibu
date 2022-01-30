function handleDelete(a){bootbox.confirm({title:"Anda ingin menghapus user ?",message:String.raw`
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">
                    <i class="dripicons-warning mr-1"></i>
                    Peringatan!
                </h4>

                <ul>
                    <li>Tindakan ini tidak dapat dibatalkan.</li>
                    <li>User yang dihapus tidak dapat dikembalikan.</li>
                    <li>Pastikan anda berhati-hati dalam menghapus data.</li>
                </ul>

                <p><b>NB:</b> User tidak dapat dihapus jika memiliki data relasi pada <b>Transaksi Belanja</b>!</p>
            </div>
        `,buttons:{confirm:{label:String.raw`<i class='mdi mdi-delete mr-1'></i> Hapus`,className:"btn btn-danger btn-sm btn-rounded"},cancel:{label:String.raw`<i class='mdi mdi-close-circle mr-1'></i> Batal`,className:"btn btn-sm btn-dark btn-rounded mr-2"}},callback:t=>{if(t){const t=$("#form-delete-user");t.attr("action",`${main.baseUrl}/user/${a}`),t.submit()}}})}$(document).ready(function(){$("#avatar").change(function(a){a.preventDefault();const{files:t}=$(this)[0];t&&$("#avatar-view").attr("src",URL.createObjectURL(t[0]))}),$("button[type=reset]").click(function(){const a=$("#avatar-view");a.attr("src",a.data("src"))}),$(".menu-headers").change(function(a){const t=$(this).is(":checked"),i=$(this).data("header");$(`.${i}`).attr("disabled",!t)}),$("#is-disable-password").change(function(a){const t=$(this).is(":checked");$("#password").attr("disabled",!t)})});
