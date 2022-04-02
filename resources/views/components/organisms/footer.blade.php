<footer class="footer">
    <div class="container-fluid">
        <div class="row px-3">
            <div class="col-md-6">
                2022 - {{ date('Y') }} © {{ config('app.name') }}
            </div>

            <div class="col-md-6">
                <div class="text-md-right d-none d-md-block">
                    Version {{ config('app.version') }}
                </div>
            </div>
        </div>
    </div>
</footer>
