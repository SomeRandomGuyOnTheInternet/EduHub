<div class="">
    <div class="">
        @if ($fileType === PreviewFileTypes::Word)
            <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}' width="100%" class="border rounded"></iframe>
        @elseif ($fileType === PreviewFileTypes::PowerPoint)
            <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($fileUrl) }}" width="100%" class="border rounded"></iframe>
        @elseif ($fileType === PreviewFileTypes::Video)
            <video controls class="border rounded">
                <source src="{{ $fileUrl }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @elseif ($fileType === PreviewFileTypes::PDF)
            <iframe src="{{ url($fileUrl) }}" width="100%" height="600px" class="border rounded"></iframe>
        @elseif ($fileType === PreviewFileTypes::Image)
            <img src="{{ $fileUrl }}" alt="Image Preview" style="max-width: 100%; height: auto;" class="border rounded">
        @else
            <p>Unsupported file type</p>
        @endif
        <div>
            @if ($fileType !== PreviewFileTypes::NotAFile)
                <p class="text-muted mt-3">{{ $fileUrl }}</p>
                <a href="{{ $fileUrl }}" download class="btn btn-primary mt-1">Download File</a>
            @endif
        </div>
    </div>
</div>