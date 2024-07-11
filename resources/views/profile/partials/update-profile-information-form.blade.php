<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile picture.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <div class="mb-3">
                <img id="profilePicturePreview" src="{{ $user->profile_picture ? Storage::url($user->profile_picture) : Storage::url('profile_pictures/placeholder.jpg') }}" alt="{{ $user->name }}" class="rounded-full h-20 w-20 object-cover">
            </div>

            <div class="mb-3">
                <video id="video" width="320" height="240" autoplay class="hidden"></video>
                <canvas id="canvas" width="320" height="240" class="hidden"></canvas>
                <button type="button" id="start-camera" class="btn btn-primary">Start Camera</button>
                <button type="button" id="snap" class="btn btn-secondary hidden">Take Photo</button>
                <button type="button" id="use-photo" class="btn btn-success hidden">Use Photo</button>
            </div>
            
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" capture="user" class="hidden" onchange="loadFile(event)" />
            <input type="hidden" id="profile_picture_data" name="profile_picture_data">

            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
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
