@extends('layouts.load')

@section('content')

    <div class="add-product-content p-0 shadow-none">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-description">
                    <div class="body-area shadow-none">
                    @include('includes.admin.form-error')
                    <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                     <form id="geniusformdataedit"  action="{{ route('image.gallery.store')}}" method="POST"
                            enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="left-area">
                                        <h4 class="heading">{{ __('Language') }}</h4>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <select name="language_id" id="album_language_id">
                                        <option value="">{{__('Please Select Language')}}</option>
                                        @foreach ($languages as $language)
                                            <option value="{{$language->id}}">{{$language->language}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="left-area">
                                        <h4 class="heading">{{ __('Album') }}</h4>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <select name="image_album_id" id="image_album_id">
                                        <option value="">{{__('Please Select Your Album')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="left-area">
                                        <h4 class="heading">{{ __('Category') }}</h4>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <select name="image_category_id" id="image_category_id">
                                        <option value="">{{__('Please Select Your Category')}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                  <div class="left-area">
                                      <h4 class="heading">{{__('Gallery Images')}}</h4>
                                  </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class=" gallery content">
                                        <div class="selected-image">
                                            <div class="row">
                                                <div class="col-sm-12 text-center">
                                                    <h3>{{__('No Image Selected.')}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add-img-area">
                                        <div class="img-upload">
                                            <div id="image-preview" class="img-preview" style="background: url({{ asset('assets/admin/images/upload.png') }});">
                                                <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{__('Choose Images')}}</label>
                                                <input type="file" name="gallery[]" id="uploadgallery" class="img-upload" multiple accept="image/*">
                                            </div>
                                            <p class="text">{{__('You can select multiple images.')}}</p>
                                        </div>
                                    </div>
                                </div>
                              </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="addProductSubmit-btn"
                                        type="submit">{{ __('Create Image') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script type="text/javascript">
    "use strict"

    $(document).on('change','#album_language_id',function(){
        var language = $(this).val();
        var url = mainurl+'admin/albumByLanguage/'+language;
        $.ajax({
            type        : 'GET',
            url         : url,
            contentType : false,
            processData : false,
            data        : {},
            success     : function(data){
                            $("#image_album_id").html(data);
                            $('#image_category_id').find('option:not(:first)').remove();
            }
        })
    })

    $(document).on('change','#image_album_id',function(){
        var album = $(this).val();
        var url = mainurl+'admin/categoryByAlbum/'+album;
        $.ajax({
            type        : 'GET',
            url         : url,
            contentType : false,
            processData : false,
            data        : {},
            success     : function(data){
                            $("#image_category_id").html(data);
            }
        })
    })

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
            $('.selected-image .row').html('<div class="col-sm-12 text-center"><h3>{{__('No Image Selected.')}}</h3></div>');
            return;
        }
        for(var i = 0; i < files.length; i++)
        {
            $('.selected-image .row').append(
                '<div class="col-sm-6" data-index="' + i + '">' +
                    '<div class="img gallery-img" style="position:relative;">' +
                        '<a href="' + URL.createObjectURL(files[i]) + '" target="_blank">' +
                            '<img src="' + URL.createObjectURL(files[i]) + '" alt="gallery image">' +
                        '</a>' +
                        '<button type="button" class="remove-gallery-img" data-index="' + i + '" style="position:absolute;top:2px;right:2px;background:red;color:#fff;border:none;border-radius:50%;width:24px;height:24px;line-height:20px;cursor:pointer;font-size:14px;">&times;</button>' +
                    '</div>' +
                '</div>'
            );
        }
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