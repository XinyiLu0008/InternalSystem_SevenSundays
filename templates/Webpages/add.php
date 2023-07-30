<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Webpage $webpage
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Webpages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="webpages form content">
            <?= $this->Form->create($webpage) ?>
            <fieldset>
                <legend><?= __('Add Webpage') ?></legend>
                <?php
                    echo $this->Form->control('image');
                    echo $this->Form->control('title');
                    echo $this->Form->control('location');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
