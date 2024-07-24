<div class="w-100 d-flex justify-content-center">

    <div class="toast-container position-absolute p-4">
        @if ($errors->any())
            @foreach ($errors->all() as $message)
                <div class="toast bg-danger w-100" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body">
                        <div class="d-flex">
                            <div class="me-auto">
                                {{ $message }}
                            </div>
                            <div class="ps-3">
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        @if (session('error'))
            <div class="toast bg-danger w-100" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex">
                        <div class="me-auto">
                            {{ session('error') }}
                        </div>
                        <div class="ps-3">
                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="toast bg-success w-100" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex">
                        <div class="me-auto">
                            {{ session('success') }}
                        </div>
                        <div class="ps-3">
                            <button type="button" class="btn-close" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
