<section>
    <header>
        <p class="text-muted">
            {{ __('Update your account\'s profile picture.') }}
        </p>
    </header>

    <form method="post" action="{{ route('student.profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="mb-4">
            <div class="mb-3">
                <img id="profilePicturePreview" src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : '/images/default-profiles/placeholder.jpg' }}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
            </div>

            <div class="mb-3">
                <button type="button" id="start-camera" class="btn btn-outline-primary">Start Camera</button>
                <div>
                    <video id="video" width="320" height="240" autoplay class="hidden rounded border"></video>
                    <canvas id="canvas" width="320" height="240" class="hidden rounded border"></canvas>
                </div>
                
                <button type="button" id="snap" class="btn btn-outline-secondary hidden">Take Photo</button>
                <button type="button" id="use-photo" class="btn btn-outline-success hidden">Use Photo</button>
            </div>
            
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" capture="user" class="hidden form-control" onchange="loadFile(event)" />
            <input type="hidden" id="profile_picture_data" name="profile_picture_data">
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</section>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const startCameraButton = document.getElementById('start-camera');
    const snapButton = document.getElementById('snap');
    const usePhotoButton = document.getElementById('use-photo');
    const profilePicturePreview = document.getElementById('profilePicturePreview');
    const profilePictureData = document.getElementById('profile_picture_data');

    startCameraButton.addEventListener('click', async () => {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        video.classList.remove('hidden');
        snapButton.classList.remove('hidden');
        startCameraButton.classList.add('hidden');
    });

    snapButton.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        canvas.classList.remove('hidden');
        usePhotoButton.classList.remove('hidden');
    });

    usePhotoButton.addEventListener('click', () => {
        const dataUrl = canvas.toDataURL('image/png');
        profilePicturePreview.src = dataUrl;
        profilePictureData.value = dataUrl;
        video.classList.add('hidden');
        snapButton.classList.add('hidden');
        usePhotoButton.classList.add('hidden');
    });

    function loadFile(event) {
        var reader = new FileReader();
        reader.onload = function(){
            profilePicturePreview.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
