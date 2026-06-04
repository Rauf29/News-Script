@extends('layouts.admin')

@section('content')
<input type="hidden" id="headerdata" value="{{ __('GALLERY') }}">

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ $album ? $album->album_name : __('Deleted Album') }} / {{ $category ? $category->name : __('Deleted Category') }}</h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="{{ route('image.gallery.index') }}">{{ __('Image Gallery') }}</a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Manage Images') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="product-area">
        @include('includes.admin.flash-message')
        <div class="row">
            <div class="col-lg-12">
                <div class="mr-table allproduct">
                    <div class="d-flex justify-content-between align-items-center mb-3 px-3">
                        <h5 class="mb-0">{{ $images->count() }} {{ __('images') }}</h5>
                        <a href="{{ route('image.gallery.add.more', [$album ? $album->id : 0, $category ? $category->id : 0]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> {{ __('Upload More') }}
                        </a>
                    </div>

                    <div class="table-responsiv px-3">
                        @if($images->count() > 0)
                        <div class="row">
                            @foreach($images as $image)
                            <div class="col-sm-3 mb-3" id="gallery-item-{{$image->id}}">
                                <div style="position:relative;">
                                    <button type="button" onclick="deleteImage({{$image->id}})" style="position:absolute;top:5px;right:5px;z-index:10;width:28px;height:28px;background:rgba(0,0,0,0.6);color:#fff;border:none;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <img src="{{asset('assets/images/image-gallery/'.$image->gallery)}}" alt="" style="width:100%;height:160px;object-fit:cover;border-radius:4px;">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-5">
                            <h5 class="text-muted mb-3">{{ __('No images in this album yet.') }}</h5>
                            <a href="{{ route('image.gallery.add.more', [$album ? $album->id : 0, $category ? $category->id : 0]) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('Upload Images') }}
                            </a>
                        </div>
                        @endif
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

    function deleteImage(id) {
        if(!confirm('{{ __("Delete this image?") }}')) return;

        $.ajax({
            type: 'GET',
            url: mainurl + 'admin/image-gallery/delete/' + id,
            success: function(data) {
                toastr.success(data);
                $('#gallery-item-' + id).fadeOut(300, function() {
                    $(this).remove();
                    if($('.mr-table .row .col-sm-3').length === 0) {
                        window.location.href = '{{ route('image.gallery.index') }}';
                    }
                });
            }
        });
    }

</script>

@endsection