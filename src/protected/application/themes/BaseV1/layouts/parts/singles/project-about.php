<div id="sobre" class="aba-content">
    <?php $this->applyTemplateHook('tab-about','begin'); ?>
    
    <?php $this->part('singles/project-about--highlighted-message', ['entity' => $entity]) ?>
    
    <div class="ficha-spcultura">
        <?php if($this->isEditable() && $entity->shortDescription && strlen($entity->shortDescription) > 400): ?>
            <div class="alert warning">O limite de caracteres da descrição curta foi diminuido para 400, mas seu texto atual possui <?php echo strlen($entity->shortDescription) ?> caracteres. Você deve alterar seu texto ou este será cortado ao salvar.</div>
        <?php endif; ?>

        <p>
            <span class="js-editable" data-edit="shortDescription" data-original-title="Descrição Curta" data-emptytext="Insira uma descrição curta" data-tpl='<textarea maxlength="400"></textarea>'><?php echo $this->isEditable() ? $entity->shortDescription : nl2br($entity->shortDescription); ?></span>
        </p>
        <?php $this->applyTemplateHook('tab-about-service','before'); ?>
        <div class="servico">
            <?php $this->applyTemplateHook('tab-about-service','begin'); ?>
            <?php if($this->isEditable() || $entity->site): ?>
                <p>
                    <span class="label">Site:</span>
                    <span ng-if="data.isEditable" class="js-editable" data-edit="site" data-original-title="Site" data-emptytext="Insira a url de seu site"><?php echo $entity->site; ?></span>
                    <a ng-if="!data.isEditable" class="url" href="<?php echo $entity->site; ?>"><?php echo $entity->site; ?></a>
                </p>
            <?php endif; ?>
            <?php $this->applyTemplateHook('tab-about-service','end'); ?>
        </div>
        <?php $this->applyTemplateHook('tab-about-service','after'); ?>
    </div>

    <?php if ( $this->isEditable() || $entity->longDescription ): ?>
        <h3>Descrição</h3>
        <span class="descricao js-editable" data-edit="longDescription" data-original-title="Descrição do Projeto" data-emptytext="Insira uma descrição do projeto" ><?php echo $this->isEditable() ? $entity->longDescription : nl2br($entity->longDescription); ?></span>
    <?php endif; ?>


    <!-- Video Gallery BEGIN -->
    <?php $this->part('video-gallery.php', array('entity'=>$entity)); ?>
    <!-- Video Gallery END -->

    <!-- Image Gallery BEGIN -->
    <?php $this->part('gallery.php', array('entity'=>$entity)); ?>
    <!-- Image Gallery END -->
    
    <?php $this->applyTemplateHook('tab-about','end'); ?>
</div>
<!-- #sobre -->