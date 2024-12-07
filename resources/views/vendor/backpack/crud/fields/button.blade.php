<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <div class="row">
        <div class="col-md-12">
            @foreach($field['custom_fields'] as $custom)
                <button class="{{$custom['class']}}" value="{{$custom['value']}}"
                        name="{{$custom['name']}}" style="margin-top:10px;">
                    <i class="{{$custom['icon'] ?? ''}}"></i> {{$custom['label']}}
                </button>
            @endforeach
        </div>
    </div>
</div>
