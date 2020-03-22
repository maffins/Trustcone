<style>
    th {
        color: black !important;
        vertical-align: text-top !important;
        border: 1px solid #fff862 !important;
        background-color: #156F30 !important;
    }
</style>
<div class="documents index">
    <div class="row">
        <div class="col-md-3">
            <div class="actions">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo __('Actions'); ?></div>
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li style="display: none"><a href="/users/logout">Click here to Logout</a></li>
                            <?php if(AuthComponent::user()['user_type_id'] != 15 && AuthComponent::user()):?>
                            <?php  if (AuthComponent::user()['user_type_id'] != 9) : ?>
                            <?php if (AuthComponent::user()['user_type_id'] == 2 || AuthComponent::user()['user_type_id'] == 3 || AuthComponent::user()['user_type_id'] == 11 || AuthComponent::user()['user_type_id'] == 10 ):?>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Urgent Documents'), array('controller' => 'documents', 'action' => 'urguent'), array('escape' => false)); ?> </li>
                            <?php endif?>
                            <?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Reports'), array('controller' => 'pages', 'action' => 'report'), array('escape' => false)); ?> </li>
                            <?php endif?>
                            <?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Settings'), array('controller' => 'pages', 'action' => 'settings'), array('escape' => false)); ?> </li>
                            <?php endif?>
                            <?php if (AuthComponent::user()['user_type_id'] != 6 && AuthComponent::user()['user_type_id'] != 15 && AuthComponent::user()['user_type_id'] != 27):?>
                            <li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Documents list'), array('controller' => 'documents', 'action' => 'index'), array('escape' => false)); ?></li>
                            <?php endif?>
                            <?php if (AuthComponent::user()['user_type_id'] == 1 || AuthComponent::user()['user_type_id'] == 8 || AuthComponent::user()['user_type_id'] == 7 || AuthComponent::user()['user_type_id'] == 12 || AuthComponent::user()['user_type_id'] == 13 ):?>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Capture Document'), array('controller' => 'documents', 'action' => 'add'), array('escape' => false)); ?> </li>
                            <?php endif?>
                            <li style="display:none "><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Users'), array('controller' => 'users', 'action' => 'index'), array('escape' => false)); ?></li>
                            <?php
                     $userSession = AuthComponent::user();
                      if ($userSession['user_type_id'] == 3 || $userSession['user_type_id'] == 2 || $userSession['user_type_id'] == 11 || $userSession['user_type_id'] == 10):
                ?>

                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('View Documents by directorates'), array('controller' => 'departments', 'action' => 'index'), array('escape' => false)); ?> </li>
                            <?php if (AuthComponent::user()['user_type_id'] == 6 ):?>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Reports'), array('controller' => 'pages', 'action' => 'report'), array('escape' => false)); ?> </li>
                            <li><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Settings'), array('controller' => 'pages', 'action' => 'settings'), array('escape' => false)); ?> </li>
                            <?php endif?>
                            <?php
                 endif;

                     if ($userSession['user_type_id'] == 3 || $userSession['user_type_id'] == 2 ):
                ?>
                            <li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                            <li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                            <?php endif ; ?>
                            <?php endif ; ?> <!-- /#sidebar-wrapper -->
                            <?php endif; ?>
                            <?php if (AuthComponent::user()['user_type_id'] == 15):?>
                            <li  style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?></li>

                            <li ><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Capture Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'add'), array('escape' => false)); ?></li>

                            <?php endif?>

                            <?php if (AuthComponent::user()['user_type_id'] == 9):?>
                            <li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;'.__('Council Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                            <?php endif?>

                            <?php if($logged_user['id'] == 51 || $logged_user['id'] == 245):?>
                            <li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                            <?php endif?>

                            <?php if($logged_user['id'] == 153):?>
                            <li  style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Fault list'), array('controller' => 'Faults', 'action' => 'index'), array('escape' => false)); ?></li>
                            <?php endif?>

                            <?php if($userSession['user_type_id'] == 27):?>
                            <li style="display: none"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO Documents'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                            <?php endif?>
                            <li><a href="/users/logout"><span class="glyphicon glyphicon-user"></span>Logout</a></li>
                        </ul>

                    </div><!-- end body -->
                </div><!-- end panel -->
            </div><!-- end actions -->
        </div><!-- end col md 3 -->


        <div class="col-md-9">

    <p class='btn btn-info'>Urgent Documents</b><p/>
    <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="fidu-tables1" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
        <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('Document No'); ?></th>
            <th><?php echo $this->Paginator->sort('Document Type'); ?></th>
            <th><?php echo $this->Paginator->sort('Document priority'); ?></th>
            <th><?php echo $this->Paginator->sort('Document Directorate/dept'); ?></th>
            <th><?php echo $this->Paginator->sort('Date Compiled'); ?></th>
            <th><?php echo $this->Paginator->sort('Comment'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($documents as $document): ?>
        <tr>
            <td><?php echo h($document['Document']['id']); ?>&nbsp;</td>
            <td><?php echo h($document['Document']['name']); ?>&nbsp;</td>
            <td>
                <?php
                   if ($document['Document']['priority'] == 'high')
                   {
                        echo "<b style='color:red'>High</b>";
                    }
                    else if ($document['Document']['priority'] == 'normal')
                    {
                    echo "<b style='color:red'>Normal</b>";
                    }
                    else if ($document['Document']['priority'] == 'low')
                    {
                    echo "<b style='color:orange'>Low</b>";
                    }
                    else
                    {
                    echo "<b style=''>Normal</b>";
                    }
                ?>
            </td>
            <td><?php echo h($document['Department']['name']); ?>&nbsp;</td>
            <td><?php
            if ($document['Document']['tracker'] == 2) {
    	    echo "With Manager";
    	   }
    	   if ($document['Document']['tracker'] == 3) {
    	    echo "With Budget";
    	   }
    	   if ($document['Document']['tracker'] == 4) {
    	    echo "With CFO";
    	   }
    	   if ($document['Document']['tracker'] == 5) {
    	    echo "With CEO";
    	   }
    	   $id = $document['Document']['id'];
    	   ?>&nbsp;</td>
            <td>
               <table>
                   <tr>
                       <td>Approve</td>
                       <td><input type="checkbox" name="approved" onclick='openComment(1, "<?php echo $id ?>")'></td>
                   </tr>
                   <tr>
                       <td>Decline</td>
                       <td><input type="checkbox" name="approved" onclick='openComment(2, "<?php echo $id ?>")'></td>
                   </tr>
                   <tr id="comment<?php echo $id ?>" style="display: none">
                       <td>Comment</td>
                       <td><textarea></textarea> <input type="button" value="Sumit" ></td>
                   </tr>
               </table>

            </td>

        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#fidu-tables').DataTable();
        } );
        $(document).ready(function() {
            $('#fidu-tables1').DataTable();
        } );


        function openComment(what, id) {
            if (what == 2) {
                id = "comment"+id;

                document.getElementById(id).style.display = 'block';
            }
        }
    </script>
        </div>
</div>
