@extends('frontend.postad.index')

@section('title', __('step3'))

@section('post-ad-content')
    @php
        $ad = session('ad');
    @endphp
    <!-- Steop 03 -->
    <div class="tab-pane fade show active" id="pills-advance" role="tabpanel" aria-labelledby="pills-advance-tab">
        <div class="dashboard-post__step02 step-information">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('frontend.post.step3.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-field--textarea">
                    <x-forms.label name="ad_description" for="description" />
                    <textarea required name="description" value="{{$ad->description}}" placeholder="{{ __('whats_your_thought') }}..." id="description"
                        class="@error('description') border-danger @enderror"></textarea>
                </div>
                {{--
                <div class="input-field--textarea">
                    <x-forms.label name="feature" for="feature" />
                    <div id="multiple_feature_part">
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="input-field">
                                    <input name="features[]" type="text" placeholder="{{ __('feature') }}"
                                        id="adname" class="@error('title') border-danger @enderror" />
                                </div>
                            </div>
                            <div class="col-lg-2 mt-10">
                                <a role="button" onclick="add_features_field()" class="btn bg-primary btn-sm text-light"><i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                --}}
                <div class="upload-wrapper">
                    <h3>{{ __('upload_photos') }}</h3>
                    <div class="alert alert-danger" role="alert">
                        {{ __('you_must_upload_at_least') }} 1 to {{ $settings->maximum_ad_image_limit }}
                        images.{{ __('image_must_be_in_jpg_jpeg_png_format') }}
                    </div>
                    {{-- <input id="file-1" type="file" name="images[]" multiple class="file"
                        data-overwrite-initial="false" accept="image/png, image/jpg, image/jpeg"> --}}
                    <div class="input-field">
                        {{-- <label class="active">{{ __('upload_photos') }}</label> --}}
                        <div id="multiple_image_upload" class="input_image" style="padding-top: .5rem;"></div>
                    </div>
                </div>

                <div class="dashboard-post__ads-bottom">
                    <div class="form-check">
                    </div>
                    <div class="dashboard-post__action-btns">
                        <a onclick="return confirm('Do you really want to go previous page? If you go then your step 3 data wont save!')"
                            href="{{ route('frontend.post.step2.back') }}" class="btn btn--lg btn--outline">
                            {{ __('previous') }}
                        </a>
                        <button type="submit" class="btn btn--lg">
                            {{ __('post_ads') }}
                            <span class="icon--right">
                                <x-svg.right-arrow-icon />
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('frontend_style')
    {{-- <link href="{{ asset('backend/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('image_uploader/image-uploader.css') }}">
@endsection

@section('frontend_script')
    <script src="{{ asset('image_uploader/image-uploader.min.js') }}"></script>
    <script>
        $('.input_image').imageUploader({
            maxSize: 2 * 1024 * 1024,
            maxFiles: 10,
            multiple: true,
        });
    </script>
    <script src="{{ asset('backend/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript">
    </script>
    {{-- <script src="{{ asset('backend/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('backend/plugins/bootstrap-fileinput/themes/fas/theme.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        // ads post

        // feature field
        function add_features_field() {
            $("#multiple_feature_part").append(`
            <div class="row">
                <div class="col-lg-10">
                        <div class="input-field">
                            <input name="features[]" type="text" placeholder="Feature" id="adname" class="@error('title') border-danger @enderror"/>
                        </div>
                </div>
                <div class="col-lg-2 mt-10">
                    <button onclick="remove_single_field()" id="remove_item" class="btn btn-sm bg-danger text-light"><i class="fas fa-times"></i></button>
                </div>
            </div>
        `);
        }

        $(document).on("click", "#remove_item", function() {
            $(this).parent().parent('div').remove();
        });
    </script>
@endsection
