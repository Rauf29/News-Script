@extends('layouts.admin')

@section('content')

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Edit Advertisement') }}</h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="{{ route('ads.index') }}">{{ __('Advertisement') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="add-product-content p-0">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="product-description shadow-none">
                    <div class="body-area">
                        @include('includes.admin.form-both')
                      <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                     <form id="geniusformdata" action="{{ route('ads.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Banner Image') }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="img-upload">
                                    <div id="image-preview" class="img-preview" style="background: url({{ $data->photo ? asset('assets/images/addBanner/'.$data->photo) : asset('assets/images/noimage.png') }});">
                                        <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                        <input type="file" name="photo" class="img-upload" id="image-upload">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Banner Code') }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <textarea name="banner_code" class="input-field" placeholder="{{ __('Banner Code') }}">{{ $data->banner_code }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Banner Type') }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <select name="banner_type" id="">
                                    <option value="image" {{ $data->banner_type == 'image' ? 'selected' : '' }}>{{__('Image')}}</option>
                                    <option value="code" {{ $data->banner_type == 'code' ? 'selected' : '' }}>{{__('Code')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Placement') }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <select name="add_placement" id="">
                                    <option value="">{{__('Please Select a Placement')}}</option>
                                    <option value="header" {{ $data->add_placement == 'header' ? 'selected' : '' }}>{{__('Header')}}</option>
                                    <option value="sidebar" {{ $data->add_placement == 'sidebar' ? 'selected' : '' }}>{{__('Sidebar')}}</option>
                                    <option value="footer" {{ $data->add_placement == 'footer' ? 'selected' : '' }}>{{__('Footer')}}</option>
                                    <option value="sponsor" {{ $data->add_placement == 'sponsor' ? 'selected' : '' }}>{{__('Sponsor')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                    <h4 class="heading">{{ __('Size') }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <select name="addSize" id="">
                                    <option value="">{{__('Please Select a Size')}}</option>
                                    <option value="size_300" {{ $data->addSize == 'size_300' ? 'selected' : '' }}>{{__('300x250')}}</option>
                                    <option value="size_728" {{ $data->addSize == 'size_728' ? 'selected' : '' }}>{{__('728x90')}}</option>
                                    <option value="size_468" {{ $data->addSize == 'size_468' ? 'selected' : '' }}>{{__('468x60')}}</option>
                                    <option value="size_120" {{ $data->addSize == 'size_120' ? 'selected' : '' }}>{{__('120x600')}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading">{{__('Status')}}</h4>
                              </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="custom-control custom-radio d-inline-block mr-4">
                                    <input class="custom-control-input" type="radio"  name="status" value="1" id="enable" {{ $data->status == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="enable">{{__('Enable')}}</label>
                                </div>
                                <div class="custom-control custom-radio d-inline-block">
                                    <input class="custom-control-input" type="radio" class="ml-3" name="status" id="disable" value="0" {{ $data->status == 0 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="disable">{{__('Disable')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <button class="addProductSubmit-btn"
                                    type="submit">{{ __('Update Advertisement') }}</button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

