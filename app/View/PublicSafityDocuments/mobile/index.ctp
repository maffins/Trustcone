<div class="meetings index">

    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?php echo __('PUBLIC SAFETY AND TRANSPORT SECTION 80 COMMITTEE'); ?></h1>
            </div>
        </div><!-- end col md 12 -->
    </div><!-- end row -->



    <div class="row">
        <div class="col-md-12">
            <table cellpadding="0" cellspacing="0" class="table table-striped" style="margin: 0 auto">
                <thead>
                <tr>
                    <th ><?php echo $this->Paginator->sort('name'); ?></th>
                    <th ><?php echo $this->Paginator->sort('created'); ?></th>
                   </tr>
                </thead>
                <tbody>
                <?php foreach ($meetings as $meeting): //print_r($meeting);?>
                <tr>
                    <td >&nbsp;<?php echo $this->Html->link($meeting['Meeting']['name'], array('action' => 'view', $meeting['Meeting']['id']), array('escape' => false)); ?></td>
                    <td ><?php echo h($meeting['Meeting']['created']); ?>&nbsp;</td>

                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <p>
                <small><?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?></small>
            </p>

            <?php
			$params = $this->Paginator->params();
            if ($params['pageCount'] > 1) {
            ?>
            <ul class="pagination pagination-sm">
                <?php
					echo $this->Paginator->prev('&larr; Previous', array('class' => 'prev','tag' => 'li','escape' => false), '<a onclick="return false;">&larr; Previous</a>', array('class' => 'prev disabled','tag' => 'li','escape' => false));
                echo $this->Paginator->numbers(array('separator' => '','tag' => 'li','currentClass' => 'active','currentTag' => 'a'));
                echo $this->Paginator->next('Next &rarr;', array('class' => 'next','tag' => 'li','escape' => false), '<a onclick="return false;">Next &rarr;</a>', array('class' => 'next disabled','tag' => 'li','escape' => false));
                ?>
            </ul>
            <?php } ?>

        </div> <!-- end col md 9 -->
    </div><!-- end row -->


</div><!-- end containing of content -->