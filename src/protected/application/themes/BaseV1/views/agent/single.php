
<?php
$action = preg_replace("#^(\w+/)#", "", $this->template);
$this->bodyProperties['ng-app'] = "entity.app";
$this->bodyProperties['ng-controller'] = "EntityController";

$this->addEntityToJs($entity);

if($this->isEditable()){
    $this->addEntityTypesToJs($entity);
    $this->addTaxonoyTermsToJs('area');

    $this->addTaxonoyTermsToJs('tag');
}

$this->includeMapAssets();

$this->includeAngularEntityAssets($entity);

$editEntity = $this->controller->action === 'create' || $this->controller->action === 'edit';
?>
<?php $this->part('editable-entity', array('entity'=>$entity, 'action'=>$action));  ?>

<article class="main-content agent">
    <header class="main-content-header">
        <?php $this->part('singles/header-image', ['entity' => $entity]); ?>

        <?php $this->part('singles/entity-status', ['entity' => $entity]); ?>

        <div class="header-content">
            <?php $this->applyTemplateHook('header-content','begin'); ?>

            <?php $this->part('singles/avatar', ['entity' => $entity, 'default_image' => 'img/avatar--agent.png']); ?>

            <?php $this->part('singles/type', ['entity' => $entity]) ?>

            <?php $this->part('singles/name', ['entity' => $entity]) ?>

            <?php $this->applyTemplateHook('header-content','end'); ?>
        </div>
        <!--.header-content-->
        <?php $this->applyTemplateHook('header-content','after'); ?>
    </header>
    <!--.main-content-header-->
    <?php $this->applyTemplateHook('header','after'); ?>

    <?php $this->applyTemplateHook('tabs','before'); ?>
    <ul class="abas clearfix clear">
        <?php $this->applyTemplateHook('tabs','begin'); ?>
        <li class="active"><a href="#sobre">Sobre</a></li>
        <li><a href="#permissao">Permissões</a></li>
        <?php $this->applyTemplateHook('tabs','end'); ?>
    </ul>
    <?php $this->applyTemplateHook('tabs','after'); ?>

    <div class="tabs-content">
        <?php $this->applyTemplateHook('tabs-content','begin'); ?>
        <div id="sobre" class="aba-content">
            <?php $this->applyTemplateHook('tab-about','begin'); ?>
            <div class="ficha-spcultura">
                <?php if($this->isEditable() && $entity->shortDescription && strlen($entity->shortDescription) > 400): ?>
                    <div class="alert warning">O limite de caracteres da descrição curta foi diminuido para 400, mas seu texto atual possui <?php echo strlen($entity->shortDescription) ?> caracteres. Você deve alterar seu texto ou este será cortado ao salvar.</div>
                <?php endif; ?>

                <p>
                    <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"shortDescription") && $editEntity? 'required': '');?>" data-edit="shortDescription" data-original-title="Descrição Curta" data-emptytext="Insira uma descrição curta" data-showButtons="bottom" data-tpl='<textarea maxlength="400"></textarea>'><?php echo $this->isEditable() ? $entity->shortDescription : nl2br($entity->shortDescription); ?></span>
                </p>
                <?php $this->applyTemplateHook('tab-about-service','before'); ?>
                <div class="servico">
                    <?php $this->applyTemplateHook('tab-about-service','begin'); ?>

                    <?php if($this->isEditable() || $entity->site): ?>
                        <p><span class="label">Site:</span>
                        <?php if($this->isEditable()): ?>
                            <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"site") && $editEntity? 'required': '');?>" data-edit="site" data-original-title="Site" data-emptytext="Insira a url de seu site"><?php echo $entity->site; ?></span></p>
                        <?php else: ?>
                            <a class="url" href="<?php echo $entity->site; ?>"><?php echo $entity->site; ?></a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if($this->isEditable()): ?>
                        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Nome:</span> <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"nomeCompleto") && $editEntity? 'required': '');?>" data-edit="nomeCompleto" data-original-title="Nome Completo ou Razão Social" data-emptytext="Insira seu nome completo ou razão social"><?php echo $entity->nomeCompleto; ?></span></p>
                        <p class="privado"><span class="icon icon-private-info"></span><span class="label">CPF/CNPJ:</span> <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"documento") && $editEntity? 'required': '');?>" data-edit="documento" data-original-title="CPF/CNPJ" data-emptytext="Insira o CPF ou CNPJ com pontos, hífens e barras"><?php echo $entity->documento; ?></span></p>
                        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Data de Nascimento/Fundação:</span>
                            <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"dataDeNascimento") && $this->isEditable()? 'required': '');?>" data-type="date" data-edit="dataDeNascimento" data-viewformat="dd/mm/yyyy" data-showbuttons="false" data-original-title="Data de Nascimento/Fundação" data-emptytext="Insira a data de nascimento ou fundação do agente">
                                <?php $dtN = (new DateTime)->createFromFormat('Y-m-d', $entity->dataDeNascimento); echo $dtN ? $dtN->format('d/m/Y') : ''; ?>
                            </span>
                        </p>
                        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Gênero:</span> <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"genero") && $editEntity? 'required': '');?>" data-edit="genero" data-original-title="Gênero" data-emptytext="Selecione o gênero se for pessoa física"><?php echo $entity->genero; ?></span></p>
                        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Orientação Sexual:</span> <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"orientacaoSexual") && $editEntity? 'required': '');?>" data-edit="orientacaoSexual" data-original-title="Orientação Sexual" data-emptytext="Selecione a orientação sexual se for pessoa física"><?php echo $entity->orientacaoSexual; ?></span></p>
                        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Raça/Cor:</span> <span class="js-editable  <?php echo ($entity->isPropertyRequired($entity,"raca") && $editEntity? 'required': '');?>" data-edit="raca" data-original-title="Raça/cor" data-emptytext="Selecione a raça/cor se for pessoa física"><?php echo $entity->raca; ?></span></p>

                        <p class="privado"><span class="icon icon-private-info"></span><span class="label">Email Privado:</span> <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"emailPrivado") && $editEntity? 'required': '');?>" data-edit="emailPrivado" data-original-title="Email Privado" data-emptytext="Insira um email que não será exibido publicamente"><?php echo $entity->emailPrivado; ?></span></p>
                    <?php endif; ?>

                    <?php if($this->isEditable() || $entity->emailPublico): ?>
                        <p><span class="label">Email:</span> <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"emailPublico") && $this->isEditable()? 'required': '');?>" data-edit="emailPublico" data-original-title="Email Público" data-emptytext="Insira um email que será exibido publicamente"><?php echo $entity->emailPublico; ?></span></p>
                    <?php endif; ?>

                    <?php if($this->isEditable() || $entity->telefonePublico): ?>
                    <p><span class="label">Telefone Público:</span> <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefonePublico") && $this->isEditable()? 'required': '');?>" data-edit="telefonePublico" data-original-title="Telefone Público" data-emptytext="Insira um telefone que será exibido publicamente"><?php echo $entity->telefonePublico; ?></span></p>
                    <?php endif; ?>

                    <?php if($this->isEditable()): ?>
                    <p class="privado"><span class="icon icon-private-info"></span><span class="label">Telefone 1:</span> <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefone1") && $this->isEditable()? 'required': '');?>" data-edit="telefone1" data-original-title="Telefone Privado" data-emptytext="Insira um telefone que não será exibido publicamente"><?php echo $entity->telefone1; ?></span></p>
                    <p class="privado"><span class="icon icon-private-info"></span><span class="label">Telefone 2:</span> <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefone2") && $this->isEditable()? 'required': '');?>" data-edit="telefone2" data-original-title="Telefone Privado" data-emptytext="Insira um telefone que não será exibido publicamente"><?php echo $entity->telefone2; ?></span></p>
                    <?php endif; ?>
                    <?php $this->applyTemplateHook('tab-about-service','end'); ?>
                </div>
                <?php $this->applyTemplateHook('tab-about-service','after'); ?>

                <?php $this->part('singles/location', ['entity' => $entity, 'has_private_location' => true]); ?>

            </div>
            <!--.ficha-spcultura-->

            <?php if ( $this->isEditable() || $entity->longDescription ): ?>
                <h3>Descrição</h3>
                <span class="descricao js-editable <?php echo ($entity->isPropertyRequired($entity,"longDescription") && $this->isEditable()? 'required': '');?>" data-edit="longDescription" data-original-title="Descrição do Agente" data-emptytext="Insira uma descrição do agente" ><?php echo $this->isEditable() ? $entity->longDescription : nl2br($entity->longDescription); ?></span>
            <?php endif; ?>
            <!--.descricao-->
            <!-- Video Gallery BEGIN -->
                <?php $this->part('video-gallery.php', array('entity'=>$entity)); ?>
            <!-- Video Gallery END -->
            <!-- Image Gallery BEGIN -->
                <?php $this->part('gallery.php', array('entity'=>$entity)); ?>
            <!-- Image Gallery END -->

            <?php $this->applyTemplateHook('tab-about','end'); ?>
        </div>
        <!-- #sobre -->
        <!-- #permissao -->
        <?php $this->part('singles/permissions') ?>
        <!-- #permissao -->

        <?php $this->applyTemplateHook('tabs-content','end'); ?>
    </div>
    <!-- .tabs-content -->
    <?php $this->applyTemplateHook('tabs-content','after'); ?>

    <?php $this->part('owner', array('entity' => $entity, 'owner' => $entity->owner)); ?>

    <div class="denuncia">
        <input class="botao" type="button" name="Envia" value="Denuncie Abusos">
    </div>
    
    <form class="formulario hidden">
      <p>
        Nome:<br />
        <input type="text" rows="5" name="nome">
      </p>
      <p>
        E-mail:<br />
        <input type="text" rows="5" name="email">
      </p>
        Mensagem:<br />
        <textarea type="text" rows="5" cols="40" name="mensagem"></textarea>
      </p>
      <p>
        <input type="submit" value="Enviar Denúncia">
      </p>
    </form>

</article>
<div class="sidebar-left sidebar agent">
	<!-- Related Seals BEGIN -->
    <?php $this->part('related-seals.php', array('entity'=>$entity)); ?>
    <!-- Related Seals END -->

    <?php $this->part('widget-areas', array('entity'=>$entity)); ?>
    <?php $this->part('widget-tags', array('entity'=>$entity)); ?>
    <?php $this->part('redes-sociais', array('entity'=>$entity)); ?>
</div>
<div class="sidebar agent sidebar-right">
    <?php if($this->controller->action == 'create'): ?>
        <div class="widget">
            <p class="alert info">Para adicionar arquivos para download ou links, primeiro é preciso salvar o agente.<span class="close"></span></p>
        </div>
    <?php endif; ?>

    <!-- Related Agents BEGIN -->
        <?php $this->part('related-agents.php', array('entity'=>$entity)); ?>
    <!-- Related Agents END -->

    <!-- Children BEGIN -->
        <?php $this->part('singles/list-entities.php', array('entities'=>$entity->spaces, 'title' => 'entities: Spaces of the agent')); ?>
    <!-- Children END -->

    <!-- Children BEGIN -->
        <?php $this->part('singles/list-entities.php', array('entities'=>$entity->children, 'title' => 'entities: Agent children')); ?>
    <!-- Children END -->

    <!--
    <div class="widget">
        <h3>Projetos do agente</h3>
        <ul>
            <li><a href="#">Projeto 1</a></li>
            <li><a href="#">Projeto 2</a></li>
            <li><a href="#">Projeto 3</a></li>
        </ul>
    </div>
    -->

    <!-- Downloads BEGIN -->
        <?php $this->part('downloads.php', array('entity'=>$entity)); ?>
    <!-- Downloads END -->

    <!-- Link List BEGIN -->
        <?php $this->part('link-list.php', array('entity'=>$entity)); ?>
    <!-- Link List END -->


</div>
<script type="text/javascript">
  var botao = document.querySelector(".botao");
  botao.addEventListener("click", function(){
    var formulario = document.querySelector(".formulario");
    formulario.classList.toggle("hidden");
  }, true)

</script>
