@extends('backpack::layout')

@section('after_styles')

    <!-- CRUD FORM CONTENT - crud_fields_styles stack -->
    <style>
            .hide {
                display: none;
            }
            .image .btn-group {
                margin-top: 10px;
            }
            img {
                max-width: 100%; /* This rule is very important, please do not ignore this! */
            }
            .img-container, .img-preview {
                width: 100%;
                text-align: center;
            }
            .img-preview {
                float: left;
                margin-right: 10px;
                margin-bottom: 10px;
                overflow: hidden;
            }
            .preview-lg {
                width: 263px;
                height: 148px;
            }

            .btn-file {
                position: relative;
                overflow: hidden;
            }
            .btn-file input[type=file] {
                position: absolute;
                top: 0;
                right: 0;
                min-width: 100%;
                min-height: 100%;
                font-size: 100px;
                text-align: right;
                filter: alpha(opacity=0);
                opacity: 0;
                outline: none;
                background: white;
                cursor: inherit;
                display: block;
            }
        </style>

@endsection



@section('header')
<section class="content-header">

    <h1>
        {{ trans('backpack::base.my_account') }}
    </h1>

    <ol class="breadcrumb">

        <li>
            <a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a>
        </li>

        <li>
            <a href="{{ route('backpack.account.info') }}">{{ trans('backpack::base.my_account') }}</a>
        </li>

        <li class="active">
            {{ trans('backpack::base.change_password') }}
        </li>

    </ol>

</section>
@endsection

@section('content')

<div class="row">
    <div class="col-md-3">
        @include('backpack::auth.account.sidemenu')
    </div>
    <div class="col-md-6">

        <form method="post" action="user-change-image/{{$user->id}}" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit</h3>
                </div>
                <div class="box-body row display-flex-wrap" style="display: flex;flex-wrap: wrap;">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- load the view from type and view_namespace attribute if set -->
                    <div data-preview="#image" data-aspectratio="1" data-crop="1" class="form-group col-md-12 image">
                        <div>
                            <label>Profile Image</label>
                        </div>
                        <!-- Wrap the image or canvas element with a block element (container) -->
                        <div class="row">
                            <div class="col-sm-6" style="margin-bottom: 20px;">
                                <img id="mainImage" src="../{{$user->image}}">
                            </div>
                            <div class="col-sm-3">
                                <div class="docs-preview clearfix">
                                    <div id="image" class="img-preview preview-lg">
                                        <img src="" style="display: block; min-width: 0px !important; min-height: 0px !important; max-width: none !important; max-height: none !important; margin-left: -32.875px; margin-top: -18.4922px; transform: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group">
                            <label class="btn btn-primary btn-file">Choose file
                                <input type="file" accept="image/*" id="uploadImage" class="hide">
                                <input type="hidden" id="hiddenImage" name="image" value="../{{$user->image}}">
                            </label>
                            <button class="btn btn-default" id="rotateLeft" type="button" style="display: none;"><i class="fa fa-rotate-left"></i></button>
                            <button class="btn btn-default" id="rotateRight" type="button" style="display: none;"><i class="fa fa-rotate-right"></i></button>
                            <button class="btn btn-default" id="zoomIn" type="button" style="display: none;"><i class="fa fa-search-plus"></i></button>
                            <button class="btn btn-default" id="zoomOut" type="button" style="display: none;"><i class="fa fa-search-minus"></i></button>
                            <button class="btn btn-warning" id="reset" type="button" style="display: none;"><i class="fa fa-times"></i></button>
                            <button class="btn btn-danger" id="remove" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>


                    <!-- load the view from type and view_namespace attribute if set -->

                        <!-- hidden input -->
                    <div class="hidden">
                      <input type="hidden" name="id" value="{{$user->id}}" class="form-control">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <div id="saveActions" class="form-group">
                        <input type="hidden" name="save_action" value="save_and_back">

                        <div class="btn-group">

                            <button type="submit" class="btn btn-success">
                                <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                                <span data-value="save_and_back">Save and back</span>
                            </button>

                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">▼</span>
                            </button>

                            <ul class="dropdown-menu">
                                <li><a href="javascript:void(0);" data-value="save_and_edit">Save and edit this item</a></li>
                                <li><a href="javascript:void(0);" data-value="save_and_new">Save and new item</a></li>
                            </ul>

                        </div>

                        <a href="edit-account-info" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Cancel</a>
                    </div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </form>



<!--
        <form class="form" action="{{ route('backpack.account.image') }}" method="post" enctype="multipart/form-data">

            {!! csrf_field() !!}

            <div class="box">

                <div class="box-body backpack-profile-form">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->count())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif



                    <div class="form-group">
                           <div class="col-md-4">

                                {!! Form::file('file_image', array('class' => 'image')) !!}

                            </div>


                    </div>

                </div>

                <div class="box-footer">

                    <button type="submit" class="btn btn-success"><span class="ladda-label"><i class="fa fa-save"></i> Change Image</span></button>
                    <a href="{{ backpack_url() }}" class="btn btn-default"><span class="ladda-label">{{ trans('backpack::base.cancel') }}</span></a>

                </div>
            </div>

        </form>
!-->
    </div>
</div>


@endsection


@section('after_scripts')
    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/edit.js') }}"></script>


    <script>
            jQuery(document).ready(function($) {
                // Loop through all instances of the image field
                $('.form-group.image').each(function(index){
                    // Find DOM elements under this form-group element
                    var $mainImage = $(this).find('#mainImage');
                    var $uploadImage = $(this).find("#uploadImage");
                    var $hiddenImage = $(this).find("#hiddenImage");
                    var $rotateLeft = $(this).find("#rotateLeft")
                    var $rotateRight = $(this).find("#rotateRight")
                    var $zoomIn = $(this).find("#zoomIn")
                    var $zoomOut = $(this).find("#zoomOut")
                    var $reset = $(this).find("#reset")
                    var $remove = $(this).find("#remove")
                    // Options either global for all image type fields, or use 'data-*' elements for options passed in via the CRUD controller
                    var options = {
                        viewMode: 2,
                        checkOrientation: false,
                        autoCropArea: 1,
                        responsive: true,
                        preview : $(this).attr('data-preview'),
                        aspectRatio : $(this).attr('data-aspectRatio')
                    };
                    var crop = $(this).attr('data-crop');

                    // Hide 'Remove' button if there is no image saved
                    if (!$mainImage.attr('src')){
                        $remove.hide();
                    }
                    // Initialise hidden form input in case we submit with no change
                    $hiddenImage.val($mainImage.attr('src'));


                    // Only initialize cropper plugin if crop is set to true
                    if(crop){

                        $remove.click(function() {
                            $mainImage.cropper("destroy");
                            $mainImage.attr('src','');
                            $hiddenImage.val('');
                            $rotateLeft.hide();
                            $rotateRight.hide();
                            $zoomIn.hide();
                            $zoomOut.hide();
                            $reset.hide();
                            $remove.hide();
                        });
                    } else {

                        $(this).find("#remove").click(function() {
                            $mainImage.attr('src','');
                            $hiddenImage.val('');
                            $remove.hide();
                        });
                    }

                    $uploadImage.change(function() {
                        var fileReader = new FileReader(),
                                files = this.files,
                                file;

                        if (!files.length) {
                            return;
                        }
                        file = files[0];

                        if (/^image\/\w+$/.test(file.type)) {
                            fileReader.readAsDataURL(file);
                            fileReader.onload = function () {
                                $uploadImage.val("");
                                if(crop){
                                    $mainImage.cropper(options).cropper("reset", true).cropper("replace", this.result);
                                    // Override form submit to copy canvas to hidden input before submitting
                                    $('form').submit(function() {
                                        var imageURL = $mainImage.cropper('getCroppedCanvas').toDataURL(file.type);
                                        $hiddenImage.val(imageURL);
                                        return true; // return false to cancel form action
                                    });
                                    $rotateLeft.click(function() {
                                        $mainImage.cropper("rotate", 90);
                                    });
                                    $rotateRight.click(function() {
                                        $mainImage.cropper("rotate", -90);
                                    });
                                    $zoomIn.click(function() {
                                        $mainImage.cropper("zoom", 0.1);
                                    });
                                    $zoomOut.click(function() {
                                        $mainImage.cropper("zoom", -0.1);
                                    });
                                    $reset.click(function() {
                                        $mainImage.cropper("reset");
                                    });
                                    $rotateLeft.show();
                                    $rotateRight.show();
                                    $zoomIn.show();
                                    $zoomOut.show();
                                    $reset.show();
                                    $remove.show();

                                } else {
                                    $mainImage.attr('src',this.result);
                                    $hiddenImage.val(this.result);
                                    $remove.show();
                                }
                            };
                        } else {
                            alert("Please choose an image file.");
                        }
                    });

                });
            });
        </script>

        <script type="text/javascript">
    </script>
@endsection
