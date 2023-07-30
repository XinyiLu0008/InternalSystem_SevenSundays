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
            <?= $this->Html->link(__('Edit Webpage'), ['action' => 'edit', $webpage->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Webpage'), ['action' => 'delete', $webpage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $webpage->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Webpages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Webpage'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="webpages view content">
            <h3><?= h($webpage->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><?= h($webpage->image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($webpage->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= h($webpage->location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($webpage->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
