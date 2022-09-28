@extends('frontend.postad.index')

@section('title', __('step1'))

@section('post-ad-content')
    <!-- Step 01 -->
    <div class="tab-pane fade show active" id="pills-basic" role="tabpanel" aria-labelledby="pills-basic-tab">
        <div class="dashboard-post__information step-information">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('frontend.post.store') }}" method="POST">
                @csrf
                <div class="dashboard-post__information-form">
                    <div class="input-field__group">
                        <div class="input-field">
                            <x-forms.label name="ad_name" required="true" for="adname" />
                            <input required value="{{ $ad->title ?? old('title') }}" name="title" type="text"
                                placeholder="{{ __('ad_name') }}" id="adname"
                                class="@error('title') border-danger @enderror" />
                        </div>
                        <div class="input-field">
                            <x-forms.label name="price" required="true" for="price">
                                ({{ config('zakirsoft.currency_symbol') }})
                            </x-forms.label>
                            <input required value="{{ $ad->price ?? old('price') }}" name="price" type="number" min="1"
                                placeholder="{{ __('price') }}" id="price"
                                class="@error('price') border-danger @enderror" />
                        </div>
                    </div>
                    <div class="input-field__group">
                        <div class="input-select">
                            <x-forms.label name="category" required="true" for="allCategory" />
                            <select name="category_id" id="ad_category"
                                class="form-control select-bg @error('category_id') border-danger @enderror">
                                <option value="" hidden>{{ __('select_category') }}</option>
                                @isset($ad->category_id)
                                    @foreach ($categories as $category)
                                        <option {{ $category->id == $ad->category_id ? 'selected' : '' }} value="{{ $category->id }}" data-is_show_brand="{{ $category->is_show_brand }}">{{ $category->name }}</option>
                                    @endforeach
                                @else
                                    @foreach ($categories as $category)
                                        <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}" data-is_show_brand="{{ $category->is_show_brand }}">{{ $category->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="input-select">
                            <x-forms.label name="subcategory" required="" for="subcategory" />
                            <select name="subcategory_id" id="ad_subcategory"
                                class="form-control select-bg @error('subcategory_id') border-danger @enderror">
                                <option value="" selected>{{ __('select_subcategory') }}</option>
                            </select>
                        </div>
                    </div>
                <div class="row">


                    <div class="col-xl-4">
                            <div class="input-field__group">
                                <div class="input-select">
                                    <x-forms.label name="{{__('Product Status')}}" for="product_status" />
                                    <select name="product_status_id" id="product_status"
                                        class="form-control select-bg @error('product_status_id') border-danger @enderror">
                                        <option value="0" {{ old('product_status_id') == 0 ? 'selected':'' }}>{{ __('Like') }}</option>
                                        <option value="1" {{ old('product_status_id') == 1 ? 'selected':'' }}>{{ __('Used') }}</option>
                                        <option value="2" {{ old('product_status_id') == 2 ? 'selected':'' }}>{{ __('Requires Fixing') }}</option>
                                        <option value="3" {{ old('product_status_id') == 3 ? 'selected':'' }}>{{ __('Irrelevant') }}</option>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="input-field__group">
                                <div class="input-select">
                                    <x-forms.label name="{{__('For SaleDelivery')}}" for="delivery_sell" />
                                    <select name="delivery_sell_id" id="delivery_sell"
                                        class="form-control select-bg @error('delivery_sell_id') border-danger @enderror">
                                        <option value="0" {{ old('delivery_sell_id') == 0 ? 'selected':'' }}>{{ __('Delivery') }}</option>
                                        <option value="1" {{ old('delivery_sell_id') == 1 ? 'selected':'' }}>{{ __('Sell') }}</option>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="input-field__group" id="brand_div">
                                <div class="input-select">
                                    <x-forms.label name="brand" for="brand" :required="false" />
                                    <select name="brand_id" id="brandd"
                                        class="form-control select-bg @error('brand_id') border-danger @enderror">
                                        <option value="" hidden>{{ __('select_brand') }}</option>
                                        @isset($ad->brand_id)
                                            @foreach ($brands as $brand)
                                                <option {{ $brand->id == $ad->brand_id ? 'selected' : '' }}
                                                    value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @else
                                            @foreach ($brands as $brand)
                                                <option {{ old('brand_id') == $brand->id ? 'selected' : '' }}
                                                    value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if (session('user_plan')->featured_limit)
                            <div class="col-lg-3">
                                <div class="form-check">
                                    <input name="featured" type="hidden" value="0">
                                    @isset($ad->featured)
                                        <input {{ $ad->featured == 1 ? 'checked' : '' }} value="1" name="featured"
                                            type="checkbox" class="form-check-input" id="featured" />
                                    @else
                                        <input value="1" name="featured" type="checkbox" class="form-check-input"
                                            id="featured" />
                                    @endisset
                                    <x-forms.label name="featured" :required="false" class="form-check-label"
                                        for="featured" />
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="dashboard-post__action-btns">
                    <!-- <a href="{{ route('frontend.post.rules') }}" class="btn btn--lg btn--outline">
                        {{ __('view_posting_rules') }}
                    </a> -->
                    <button type="submit" class="btn btn--lg text-white">
                        {{ __('next_steps') }}
                        <span class="icon--right">
                            <x-svg.right-arrow-icon />
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
