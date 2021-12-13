{{-- App Search desktop --}}
<form class="app-search d-none d-lg-block">
    <div class="position-relative">
        <input type="text" class="form-control" placeholder="Search...">
        <span class="fa fa-search"></span>
    </div>
</form>

{{-- App Search mobile --}}
<div class="dropdown d-inline-block d-lg-none ml-2">
    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="mdi mdi-magnify"></i>
    </button>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-search-dropdown">
        <form class="p-3">
            <div class="form-group m-0">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
