<div class="d-flex align-items-center justify-content-center w-100" style="height: 100vh;">
    <div class="d-none d-lg-block">  
        <div class="align-items-center p-5 shadow-lg rounded border">
            {{ $slot }}
        </div>
    </div>
    <div class="d-lg-none">
        <div class="align-items-center p-5">
            {{ $slot }}
        </div>
    </div>
</div>