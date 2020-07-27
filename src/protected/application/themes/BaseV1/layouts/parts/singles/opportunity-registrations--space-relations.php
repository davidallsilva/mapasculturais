<?php
use MapasCulturais\App;

$can_edit = $entity->canUser('modifyRegistrationFields');

$ditable_class = $can_edit ? 'js-editable editable editable-click' : '';

$editEntity = $this->controller->action === 'create' || $this->controller->action === 'edit';
//var_dump($app->_config);
$metadata_name = 'useSpaceRelation';
//dump($entity->$metadata_name);
$option_label = $entity->$metada\ta_name ? $entity->$metadata_name : 'dontUse';

$projectMeta = \MapasCulturais\Entities\Project::getPropertiesMetadata();
//dump($projectMeta);
//dump($app);
$message = $projectMeta['useSpaceRelation']['options'];
// dump($message);
// dump($app);
// die();
?>

<?php if ($entity->isRegistrationOpen() || $this->isEditable()): ?>
        <div id="registration-space-relation" class="registration-fieldset">
            <h4><?php \MapasCulturais\i::_e("Espaço Cultural");?></h4>
            <p class="registration-help">
                <?php \MapasCulturais\i::_e("Uma inscrição pode pedir para que o agente relacione um Espaço Cultural a ela. Indique aqui se quer habilitar esta opção.");?>
            </p>
            <!-- <span class="js-editable editable editable-click" data-edit="useAgentRelationInstituicao" data-original-title="Instituição responsável" data-emptytext="Selecione uma opção">Não utilizar</span> -->
           <select name="idSpaceRelationForm" id="idSpaceRelationForm" class="form-control">
          
           <?php
                foreach ($message as $key => $value) {
                    echo '<option value="'.$key.'">'.$value.'</option>';
                }
           ?>
           </select>
           <script>
            $(document).ready(function() {
                $("#idSpaceRelationForm").change(function (e) { 
                    e.preventDefault();
                    var valRelation = $(this).find(":selected").val();
                    var idEntity = MapasCulturais.entity.id;
                    $.ajax({
                        type: "POST",
                        url: MapasCulturais.baseURL+'registration/spaceRel',
                        data: {object_id: idEntity, key: 'useSpaceRelationIntituicao', value : valRelation},
                        dataType: "json",
                        success: function (response) {
                            console.log('Edições salvas.');
                            //MapasCulturais.Messages.success('Edições salvas.');
                        }
                    });
                });
            });
            </script>
        </div>

    <?php else: ?>
        <p><?php \MapasCulturais\i::_e("");?></p>
<?php endif; ?>
