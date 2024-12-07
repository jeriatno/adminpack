<!-- checklist with directly provided options -->
<!-- checklist_filtered -->
@php
    $options = isset($field['options']) ? $field['options'] : [];
@endphp

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <?php $entity_model = $crud->getModel(); ?>

    <div class="row">
        @foreach ($options as $option)
            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                               name="{{ $field['name'] }}[]"
                               value="{{ $option }}"
                               @if( ( old( $field["name"] ) && in_array($option , old( $field["name"])) ) )
                                   checked = "checked"
                            @endif > {!! $option !!}
                    </label>
                </div>
            </div>
        @endforeach
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
