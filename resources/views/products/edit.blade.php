@extends('layout.main')
@section('content')
    <div class="pc-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products List</a></li>
                            <li class="breadcrumb-item" aria-current="page">Edit Product</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Edit Product</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12" bis_skin_checked="1">

            <form action="{{ route('admin.products.update' , $product->id) }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                <div class="card" bis_skin_checked="1">
                    @csrf
                    <div class="card-body" bis_skin_checked="1">
                        @if ($errors->any())
                            <div class="alert alert-danger mt-2" role="alert">
                                Please fill in all the required fields.
                            </div>
                        @endif
                        <div class="mt-3" bis_skin_checked="1">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control @error('product_name'){{ 'is-invalid' }}@enderror   @if(session('unique'))  is-invalid  @endif"
                                name="product_name" placeholder="Enter Product Name" value="{{old('product_name') ?? $product->product_name}}">
                        </div>
                        @error('product_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @if(session('unique') )
                        <div class="invalid-feedback d-block">{{ session('unique') }}</div>
                    @endif
                        <div class="mt-3 col-xl-6" bis_skin_checked="1">
                            <label class="form-label d-flex align-items-center">Price <i class="ph-duotone ph-info ms-1"
                                    data-bs-toggle="tooltip" data-bs-title="Price"></i></label>
                            <div class="input-group mt-3" bis_skin_checked="1">
                                <span class="input-group-text">$</span>
                                <input type="text" name="price" value="{{old('price') ?? $product->price}}"
                                    class="form-control @error('price'){{ 'is-invalid' }}@enderror" placeholder="Price">
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3" bis_skin_checked="1">
                            <label class="form-label">Category</label>
                            <select class="form-select @error('category_id'){{ 'is-invalid' }}@enderror"
                                name="category_id">
                                <option value="" selected>Select Category</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" {{$item->id == $product->category_id ? 'selected' :''}}> {{ $item->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3" bis_skin_checked="1">
                            <label class="form-label">Product Description</label>
                            <textarea id="des" class="form-control @error('product_description'){{ 'is-invalid' }}@enderror" name="product_description"
                                placeholder="Enter Product Description">{{old('product_description') ?? $product->product_description}}</textarea>
                            @error('product_description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="form-label mt-3">Product Theme</label>
                        <div class="col-xl-3" bis_skin_checked="1">
                            <label class="btn btn-outline-secondary" for="flupld" style="@error('product_theme'){{ 'border:2px solid red' }}@enderror">
                                <i class="ti ti-upload me-2"></i> Click to Upload
                            </label>
                            <input  type="file" id="flupld" name="product_theme"
                                class="d-none">
                            @error('product_theme')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Save product</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection
@push('scripts')
    <script>
        tinymce.init({
            selector: 'textarea#des', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists image',
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
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | image',
            images_file_types: 'jpg,svg,webp'
        });
    </script>
@endpush
