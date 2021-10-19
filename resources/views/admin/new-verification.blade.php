@extends('admin.base')

@section('section_title')
    <strong>Verify User</strong>
@endsection

@section('section_body')
    {{--@dd($user_meta)--}}
    <div class="row">
        <div class="col-md-12">
                <form method="POST" action="/admin/verifications/new/verify/{{ $p->user_id }}"  enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $p->id }}">
                    <input type="hidden" name="user_id" value="{{ $p->user_id }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>@lang('dashboard.yourCountry')</strong></label>
                                <select name="country" class="form-control" required>
                                    <option value="">@lang('profile.selectCountry')</option>
                                    @foreach( $countries as $country )
                                        <option value="{{ $country }}" @if(@$user_meta['country'] == $country) selected @endif>{{ $country }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="city">@lang('dashboard.yourCity')</label>
                            <input type="text" name="city" id="city" value="{{ @$user_meta['city'] ?? old( 'city' ) }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="address">@lang('dashboard.yourFullAddress')</label>
                            <textarea name="address" id="address" class="form-control" required>{{ @$user_meta['address'] ?? old( 'address' ) }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="profile_image">@lang('dashboard.idUpload')</label>
                                <input type="file" name="idUpload" accept="image/*" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <br>
                            <input type="submit" name="sb" value="Verify Now" class="btn btn-primary">
                        </div>
                    </div>

                </form>
        </div><!-- /.col-xs-12 col-md-6 -->
    </div><!-- /.row -->


@endsection