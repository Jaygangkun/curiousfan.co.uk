@extends('admin.base')

@section('section_title')
    @if($userEdit == true)
        <strong>Edit User</strong>
    @else
        <strong>Create New User</strong>
    @endif
@endsection

@section('section_body')
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    {{--@dd($user_meta)--}}

    <div class="row">
        <div class="col-md-12">
            @if($userEdit == true && $editUser->id)
            <form method="POST" action="/admin/view-user/update/{{ $editUser->id }}"  enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="user_id" value="{{ $editUser->id }}">
            @else
            <form method="POST" action="/admin/add-user/"  enctype="multipart/form-data" autocomplete="off">
            @endif
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Name</strong></label>
                            <input type="text" name="name" id="name" disabled value="@if($userEdit == true){{ $editUser->name }}@endif" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email_address">Email</label>
                            <input type="email" name="email_address" disabled id="email_address" value="@if($userEdit == true){{ $editUser->email }}@endif" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" autocomplete="off" name="password" disabled id="password" value="" class="form-control" title="Password must contain: Minimum 8 characters atleast 1 Alphabet and 1 Number" @if($userEdit == false) required @endif pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password1">Retype Password</label>
                            <input type="password" name="password1" autocomplete="off" disabled id="password1" value="" class="form-control" @if($userEdit == false) required @endif>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-header with-border"><strong>Profile Details</strong>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Please Select</option>
                                @foreach( $all_categories AS $c )
                                    @if($userEdit == true)
                                    <option value="{{ $c->id }}" @if($c->id == $editUser->profile->category_id) selected @endif>{{ $c->category }}</option>
                                    @else
                                    <option value="{{ $c->id }}" >{{ $c->category }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="isCreating">User Type</label>
                                <select id="isCreating" name="isCreating" class="form-control">
                                    <option value="No" @if($userEdit == true && $editUser->isCreating == 'No') selected @endif>Standard User</option>
                                    <option value="Yes" @if($userEdit == true && $editUser->isCreating == 'Yes') selected @endif>Creators Account</option>
                                </select>
                        </div>
                    </div>
                    @if($userEdit == true)
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label >Profile Picture View</label>
                                <a href="{{ asset('public/uploads/' . $editUser->profile->profilePic) }}" target="_blank">
                                    <img src="{{ asset('public/uploads/' . $editUser->profile->profilePic) }}" width="100%" class="img-responsive"/>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profilePic">Update Profile Picture (Min 200x200)</label>
                                    <input id="profilePic" name="profilePic" type="file" class="file" data-preview-file-type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <label >Cover Picture View</label>
                                <a href="{{ asset('public/uploads/' . $editUser->profile->coverPic) }}" target="_blank">
                                    <img src="{{ asset('public/uploads/' . $editUser->profile->coverPic) }}" width="100%" class="img-responsive"/>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="coverPic">Update Cover Picture (Min 960x280)</label>
                                    <input id="coverPic" name="coverPic" type="file" class="file" data-preview-file-type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="profilePic">Profile Picture (Min 200x200)</label>
                            <input id="profilePic" name="profilePic" type="file" class="file" data-preview-file-type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cover_picture">Cover Picture (Min 960x280)</label>
                            <input id="coverPic" name="coverPic" type="file" class="file" data-preview-file-type="text">
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="creates">Headline</label>
                            <textarea name="creates" id="creates" class="form-control">@if($userEdit == true){{ $editUser->profile->creating }}@endif</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-header with-border"><strong>Social Profiles</strong></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fbUrl">Facebook</label>
                            <input type="text" name="fbUrl" id="fbUrl" value="@if($userEdit == true){{ $editUser->profile->fbUrl }}@endif" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="instagram">Instagram</label>
                            <input type="text" name="instaUrl" id="instaUrl" value="@if($userEdit == true){{ $editUser->profile->instaUrl }}@endif" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twUrl">Twitter</label>
                            <input type="text" name="twUrl" id="twUrl" value="@if($userEdit == true){{ $editUser->profile->twUrl }}@endif" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="youtube">Youtube</label>
                            <input type="text" name="ytUrl" id="ytUrl" value="@if($userEdit == true){{ $editUser->profile->ytUrl }}@endif" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="twitchUrl">Twitch</label>
                            <input type="text" name="twitchUrl" id="twitchUrl" value="@if($userEdit == true){{ $editUser->profile->twitchUrl }}@endif" class="form-control">
                        </div>
                    </div>
                </div>
                @php
                if($userEdit == true){
                    $customD = json_decode($editUser->profile->custom_data);
                    //print_r($customD);
                };
                @endphp
                <div class="row">
                    <div class="box-header with-border"><strong>Manual Subscribers & Fans</strong></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subscriber">Subscriber</label>
                            <input type="number" name="subscriber" id="subscriber" value="@if($userEdit == true && !empty($customD->subscribers)){{ @$customD->subscribers }}@elseif($userEdit == true && empty($customD->subscribers)){{ @$profileData->followers->count() }}@endif" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fans">Fans</label>
                            <input type="number" name="fans" id="fans" value="@if($userEdit == true && !empty($customD->fans)){{ @$customD->fans}}@else{{ @$profileData->fans_count }}@endif" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="box-header with-border"><strong>Profile Notes</strong></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="profile_note" id="profile_note" class="form-control">@if($userEdit == true){{ @$customD->admin_note }}@endif</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <input type="submit" name="sb" value="@if($userEdit == true) Update User @else Add New User @endif" class="btn btn-primary btn-block">
                    </div>
                </div>

            </form>
        </div><!-- /.col-xs-12 col-md-6 -->
    </div><!-- /.row -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/plugins/piexif.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/plugins/sortable.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/fileinput.min.js"></script>
    <script type="text/javascript">
        window.onload = function () {
            var txtPassword = document.getElementById("password");
            var txtConfirmPassword = document.getElementById("password1");
            txtPassword.onchange = ConfirmPassword;
            txtConfirmPassword.onkeyup = ConfirmPassword;
            function ConfirmPassword() {
                txtConfirmPassword.setCustomValidity("");
                if (txtPassword.value != txtConfirmPassword.value) {
                    txtConfirmPassword.setCustomValidity("Passwords do not match.");
                }
            }
        }
        function getRidOffAutocomplete(){

            var timer = window.setTimeout( function(){
                    $('#password,#name,#email_address,#password1').prop('disabled',false);
                    clearTimeout(timer);
                },
                800);
        }

        // Invoke the function, handle page load autocomplete by chrome.
        getRidOffAutocomplete();
    </script>
    <script>
        $.fn.fileinputBsVersion = "3.3.7";
        $("#profilePic, #coverPic").fileinput({
            'showUpload':true,
            'previewFileType':'any',
            'browseClass': "btn btn-success btn-block",
            'showCaption': false,
            'showRemove': true,
            'maxFileCount': 1,
            'allowedFileTypes': ["image"],
            //'elErrorContainer': "#errorBlock"
            //allowedFileExtensions: ["jpg", "gif", "png", "txt"]
        });
    </script>
@endsection