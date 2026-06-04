@extends('layouts.admin')

@section('content')
<input type="hidden" id="headerdata" value="{{ __('GALLERY') }}">

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Add Images') }}</h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="{{ route('image.gallery.index') }}">{{ __('Image Gallery') }}</a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Add Images') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-area">
        @include('includes.admin.form-success')
        @include('includes.admin.flash-message')
        <div class="row">
            <div class="col-lg-12">
                <div class="mr-table allproduct">
                    <div class="table-responsiv px-3">
                        <div class="add-product-content p-0 shadow-none">
                            <div class="product-description">
                                <div class="body-area shadow-none">
                                    @include('includes.admin.form-error')
                                    <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                                    <h5 class="mb-3">
                                        {{ __('Adding to') }}: <strong>{{ $album ? $album->album_name : __('Deleted Album') }}</strong> / <strong>{{ $category ? $category->name : __('Deleted Category') }}</strong>
                                    </h5>

                                    <form id="geniusformdataedit" action="{{ route('image.gallery.store') }}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}

                                        <input type="hidden" name="image_album_id" value="{{ $album ? $album->id : '' }}">
                                        <input type="hidden" name="image_category_id" value="{{ $category ? $category->id : '' }}">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Language') }}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <select name="language_id" id="language_id">
                                                    @foreach ($languages as $language)
                                                        <option value="{{$language->id}}" {{ $album && $album->language_id == $language->id ? 'selected' : '' }}>{{$language->language}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{__('Select Images')}}</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="gallery content">
                                                    <div class="selected-image">
                                                        <div class="row">
                                                            <div class="col-sm-12 text-center">
                                                                <h5 class="text-muted">{{__('No images selected.')}}</h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="add-img-area">
                                                    <div class="img-upload">
                                                        <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/admin/images/upload.png') }});">
                                                            <label for="uploadgallery" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{__('Choose Images')}}</label>
                                                            <input type="file" name="gallery[]" id="uploadgallery" class="img-upload" multiple accept="image/*">
                                                        </div>
                                                        <p class="text">{{__('You can select multiple images.')}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button class="addProductSubmit-btn" type="submit">{{ __('Upload Images') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    "use strict"

    var dt = new DataTransfer();

    $('#uploadgallery').on('change', function(event){
        var files = event.target.files;
        for(var i = 0; i < files.length; i++){
            dt.items.add(files[i]);
        }
        renderGalleryPreview();
    });

    function renderGalleryPreview(){
        var files = dt.files;
        $('.selected-image .row').html('');
        if(files.length == 0){
            $('.selected-image .row').html('<div class="col-sm-12 text-center"><h5 class="text-muted">{{__('No images selected.')}}</h5></div>');
            return;
        }
        var html = '';
        for(var i = 0; i < files.length; i++)
        {
            html +=
                '<div class="col-sm-3" data-index="' + i + '">' +
                    '<div style="margin-bottom:10px;position:relative;">' +
                        '<img src="' + URL.createObjectURL(files[i]) + '" alt="" style="width:100%;height:120px;object-fit:cover;border-radius:4px;">' +
                        '<button type="button" class="remove-gallery-img" data-index="' + i + '" style="position:absolute;top:2px;right:2px;background:red;color:#fff;border:none;border-radius:50%;width:24px;height:24px;line-height:20px;cursor:pointer;font-size:14px;">&times;</button>' +
                    '</div>' +
                '</div>';
        }
        $('.selected-image .row').html(html);
    }

    $(document).on('click', '.remove-gallery-img', function(){
        var index = $(this).data('index');
        dt.items.remove(index);
        renderGalleryPreview();
    })

    $('#geniusformdataedit').on('submit', function(){
        var newDt = new DataTransfer();
        for(var i = 0; i < dt.files.length; i++){
            newDt.items.add(dt.files[i]);
        }
        document.getElementById('uploadgallery').files = newDt.files;
    })

</script>

@endsection