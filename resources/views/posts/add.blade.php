@extends('layout.main')
@section('content')
    <div class="pc-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts List</a></li>
                            <li class="breadcrumb-item"><a>Edit Posts</a></li>

                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Add Post</h2>
                        </div>
                        <div class="card mt-3 col-sm-12">

                            <div class="card-body">
                                <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mt-3" bis_skin_checked="1">
                                        <label class="form-label">Topics</label>
                                        <select class="form-select @error('topic_id'){{ 'is-invalid' }}@enderror"
                                            name="topic_id">
                                            <option value="" selected>Select Topic</option>
                                            @foreach ($topics as $item)
                                                <option value="{{ $item->id }}"  {{$item->id == old('topic_id') ? 'selected' :''}}> {{ $item->topic_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('topic_id')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-3" bis_skin_checked="1">
                                        <label class="form-label">Title</label>
                                        <input type="text"
                                            class="form-control title @error('title'){{ 'is-invalid' }}@enderror" name="title"
                                            placeholder="Enter title" value="{{ old('title') }}">
                                        @error('title')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-3" bis_skin_checked="1">
                                        <label class="form-label">Slug</label>
                                        <input type="text"
                                            class="form-control slug @error('slug'){{ 'is-invalid' }}@enderror" name="slug"
                                            placeholder="Enter slug" value="{{ old('slug') }}">
                                        @error('slug')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-3" bis_skin_checked="1">
                                        <label class="form-label">Content</label>
                                        <textarea id="content" class="form-control  @error('content'){{ 'is-invalid' }}@enderror" name="content"
                                            placeholder="Enter content">{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <label class="form-label mt-3">Post Theme</label>
                                    <div class="" bis_skin_checked="1">
                                        <label class="btn btn-outline-secondary" for="flupld"
                                            style="@error('theme'){{ 'border:2px solid red' }}@enderror">
                                            <i class="ti ti-upload me-2"></i> Click to Upload
                                        </label>
                                        <input type="file" id="flupld" name="theme" class="d-none">
                                        @error('theme')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" style="color:white" class="btn btn-primary mt-2">Add</button>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.title').addEventListener('input', function(){
            var slug = document.querySelector('.slug');
            var title = this.value.toLowerCase().replaceAll(' ' , '-');
            slug.value = title;
        })
    </script>
@endsection
@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#content', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists image emoticons visualblocks',
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            /*
              URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
              images_upload_url: 'postAcceptor.php',
              here we add custom filepicker only to Image dialog
            */
            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    });
                    reader.readAsDataURL(file);
                });

                input.click();
            },
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | image | emoticons | visualblocks',
            images_file_types: 'jpg,svg,webp'
        });
    </script>
@endpush
