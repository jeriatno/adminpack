<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <?php
    $entity_model = $crud->getModel();
    if (isset($id)) {
        $data = $entity_model::with($field['relation'])->find($id);
        $relation = $data[$field['relation']];
    }
    ?>

    <div class="row">
        @foreach ($field['model']::all() as $key => $connected_entity_entry)
            <div class="col-sm-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"
                               name="{{ $field['name'] }}[]"

                               value="{{ $connected_entity_entry->getKey() }}"

                               @if( ( old( $field["name"] ) && in_array($connected_entity_entry->getKey(), old( $field["name"])) ) || (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())))
                               checked="checked"
                            @endif > {!! $connected_entity_entry->{$field['attribute']} !!}
                        <br>
                        @foreach($field['custom_fields'] as $custom_field)
                            <?php
                            $data = null;
                            if (isset($relation)) {
                                foreach ($relation as $value) {
                                    if ($value->forstok_account_id == $connected_entity_entry->id) {
                                        $data = $value;
                                    }
                                }
                            }
                            ?>
                            <p style="padding-top:10px">{{$custom_field['label']}}</p>
                            <input type="{{$custom_field['type']}}" name="{{$custom_field['name']}}[]"
                                   value="{{$data[$custom_field['name']] ?? ''}}" class="form-control"
                                   style="margin-top:10px;">
                        @endforeach

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
