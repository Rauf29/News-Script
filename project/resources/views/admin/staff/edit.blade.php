@extends('layouts.load')
@section('content')


    <div class="add-product-content  p-0 shadow-none">
        @include('includes.admin.form-error')
    	@include('includes.admin.form-success')
        <div class="row">
            <div class="col-lg-12">
                <div class="product-description">
                    <div class="body-area shadow-none">
                    <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                    <form id="geniusformdata" action="{{ route('admin.staff.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="row">
                            <div class="col-lg-12">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Staff Profile Image') }}</h4>
                            </div>
                            </div>
                            <div class="col-lg-12">
                            <div class="img-upload">
                                <div id="image-preview" class="img-preview" style="background: url({{$data->photo ? asset('assets/images/admin/'.$data->photo) : asset('assets/images/noimage.png') }});">
                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i>{{ __('Upload Image') }}</label>
                                    <input type="file" name="photo" class="img-upload" id="image-upload">
                                    </div>
                            </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                        <h4 class="heading">{{ __('Name') }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="input-field" name="name" placeholder="{{ __("User Name") }}" value="{{ $data->name}}">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                        <h4 class="heading">{{ __("Email") }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <input type="email" class="input-field" name="email" placeholder="{{ __("Email Address") }}" value="{{ $data->email}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                        <h4 class="heading">{{ __("Phone") }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="input-field" name="phone" placeholder="{{ __("Phone Number") }}" value="{{ $data->phone}}">
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                        <h4 class="heading">{{ __('Designation') }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="input-field" name="designation" placeholder="{{ __("Type Designation") }}" value="{{ $data->designation}}">
                            </div>
                        </div>













                        <div class="row">
                            <div class="col-lg-12">
                                <div class="left-area">
                                        <h4 class="heading">{{ __('Change Password') }}</h4>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="input-field" name="password" placeholder="{{ __("Password") }}" required="" value="Password is 12345678" disabled="disabled">
                            
							 <input type="hidden" class="input-field" name="password" placeholder="{{ __("Password") }}" required="" value="$2y$10$I7HjWzyAPJozo/NOHz58nuMi4U1qWoehyj12sbvK64xvMMUI4wQkW">
							</div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                            <button class="addProductSubmit-btn" type="submit">{{ __("Update") }}</button>
                            </div>
                        </div>

                    </form>


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
