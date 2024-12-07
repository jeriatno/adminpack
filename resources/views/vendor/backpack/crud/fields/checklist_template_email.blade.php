<!-- select2 -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <?php $entity_model = $crud->getModel(); ?>

    <div class="row">
        @foreach ($field['model']::all() as $connected_entity_entry)
            <div class="col-sm-4">
                <div class="checkbox">
                  <label>
                    <input class="checkbox_template_email" type="checkbox"
                      name="{{ $field['name'] }}[]"
                      value="{{ $connected_entity_entry->getKey() }}"

                      @if( 
                            ( 
                                old($field["name"]) && 
                                in_array(
                                    $connected_entity_entry->getKey(), old( $field["name"])
                                ) 
                            ) || 
                            (
                                isset($field['value']) && 
                                in_array($connected_entity_entry->getKey(), [$field['value']]
                                )
                            )
                        )
                             checked = "checked"
                      @endif > {!! $connected_entity_entry->{$field['attribute']} !!}
                  </label>
                </div>
            </div>
        @endforeach
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

    <div class="row">
        <div class="col-md-12">
            <hr />
            <div class="text-center">
                <span id="section_preview_template">
                    <a href="javascript:void(0);" class="btn btn-primary" id="control_toggle_content"><i class="fa fa-eye"></i> Preview Template</a>
                </span>
            </div>
        </div>
    </div>
</div>


<style>
.modal-dialog-template {
	width: 95%;
	height: 95%;
	padding: 2%;
	position: relative;
    display: table; /* This is important */ 
    overflow-y: auto;    
    overflow-x: auto;
}

.modal-content-template {
	height: 100%;
	border-radius: 0;
}
</style>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-template">
    <div class="modal-content modal-content-template">
      <div class="modal-header">
        <button type="button" id="edit_preview_template_content" class="btn btn-primary"><i class="fa fa-save"></i> Gunakan Template</button>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>


<script>
    $(function() {
        var templateId = "";

        getCheckedList();

		$(document).on('click', '#control_toggle_content', function() {
            templateId = getActiveTemplateId();

            if (templateId != "") {
                // get ajax ambil contentnya
                var route = "{{ backpack_url('promotion-email/template/show/') }}/" + templateId;
                
                $.ajax({
                    url: route,
                    type: 'GET',
                    success: function(result) {
                        if (result['status'] == 'success') {
                            var templateData = result['data'];

                            var content = templateData.content;

                            $('#myModal .modal-body').html(content);

                            $("#myModal").modal();
                        } else {
                            new PNotify({
                                title: "Approve Status",
                                text: "Gagal melakukan approve data",
                                type: "warning"
                            });
                        }
                    },
                    error: function(result) {
                    }
                });
            } else {
                alert('pilih template terlebih dahulu');
            }
		});

		$(document).on('show.bs.modal','#myModal', function () {
			$('#control_toggle_content').removeAttr('checked');
			$('#control_toggle_content').prop('checked', false);
		});

        $(document).on('hidden.bs.modal','#myModal', function () {
            $('#myModal .modal-body').html('');
        });

        $(document).on('click', '.checkbox_template_email', function() {
            if ($(this).is(':checked')) {
                templateId = $(this).val();
                resetCheckbox(templateId);
            }
        });

        function getActiveTemplateId()
        {
            templateId = "";
            
            $('.checkbox_template_email').each(function() {
                if ($(this).is(':checked')) {
                    templateId = $(this).val();
                    resetCheckbox(templateId);
                }
            });

            return templateId;
        }

        function resetCheckbox(except='')
        {
            $('.checkbox_template_email').each(function() {
                if (except != "" && except != $(this).val()) {
                    $(this).removeAttr('checked');
                    $(this).prop('checked', false);
                }
            });

            $('#custom_update_content_template').hide();
            $('input[name=is_content_from_template_updated]').val(0); // sign on edit
            $('#save_template').hide();
            $('#section_preview_template').show();
        }

        function getCheckedList()
        {
            $('.checkbox_template_email').each(function() {
                if ($(this).is(':checked')) {
                    templateId = $(this).val();
                }
            });
        }

        $(document).on('click', '#edit_preview_template_content', function () {
            if (templateId != "") {
                // get ajax ambil contentnya
                var route = "{{ backpack_url('promotion-email/template/show/') }}/" + templateId;
                
                $.ajax({
                    url: route,
                    type: 'GET',
                    success: function(result) {
                        if (result['status'] == 'success') {
                            var templateData = result['data'];

                            var content = templateData.content;
                            
                            $('#custom_update_content_template').show();
                            $('input[name=is_content_from_template_updated]').val(1); // sign on edit
                            $('#save_template').show();
                            // $('#section_preview_template').hide();

                            CKEDITOR.instances['ckeditor-content_template'].setData(content);

                            $("#myModal").modal('hide');
                        } else {
                            new PNotify({
                                title: "Approve Status",
                                text: "Gagal melakukan approve data",
                                type: "warning"
                            });
                        }
                    },
                    error: function(result) {
                    }
                });
            } else {
                alert('pilih template terlebih dahulu');
            }
        });
	});
</script>