<div class="page-heade" style="padding: 0 !important;align-content: center">
    <style>
        .nav-stacked > li {
            float none;
        }
        .panel-heading {
            padding: 0 !important;
        }
    </style>
<?php
    $logged_user = AuthComponent::user();
    $permissions = unserialize($logged_user['permissions']);
?>
<?php if($logged_user['id'] == 1 || $logged_user['id'] == 51 || $logged_user['id'] == 153 || $logged_user['id'] == 236 || $logged_user['id'] == 245):?>
<table>
  <tr>
    <td>
      <?php
        echo $this->Html->link('English', array('language'=>'eng'));
      ?>
    </td>
    <td>
      <?php
        echo $this->Html->link('Afrikaans', array('language'=>'afr'));
      ?>
    </td>
    <td>
      <?php
        echo $this->Html->link('Xhosa', array('language'=>'xho'));
      ?>
    </td>
    <td>
      <?php
        echo $this->Html->link('Sesotho', array('language'=>'ses'));
      ?>
    </td>
  </tr>
</table>
<?php endif;?>
    <table style="width: 75%;margin: 0 auto">
        <tr>
            <td></td>
            <td style="vertical-align: text-top;text-align: center">
                <table width="100%">
                    <tr>
                        <td><img alt="matjhabeng local municipality" src="/app/webroot/img/matjhabeng2.png" border="0"></td>
                    </tr>
                    <tr>
                        <?php if(!AuthComponent::user()):?>
                        <style>
                            h1 {
                                font-size: 27px !important;
                            }
                        </style>
                        <?php endif;?>
                        <td style="text-align: center;padding: 0">
                            <h3><?php echo __('Matjhabeng Local Municipality Document Management System'); ?> </h3>

                        </td>
                    </tr>
                </table>
            </td>
            <td></td>
        </tr>
        <?php if(AuthComponent::user()):?>
        <tr>
            <td colspan="3" style="text-align: center;vertical-align: text-top">
                <?php
                          $logged_user = AuthComponent::user();
                          $who = "";
                          if ($logged_user['user_type_id'] != 9) {
                              if ($logged_user['user_type_id'] == 1) {
                                $who = "Compiler";
                              }
                              if ($logged_user['user_type_id'] == 2) {
                                $who = "CFO";
                              }
                              if ($logged_user['user_type_id'] == 3) {
                                $who = "CEO/Municipal manager";
                              }
                              if ($logged_user['user_type_id'] == 7) {
                                $who = "CFO Office";
                              }
                              if ($logged_user['user_type_id'] == 8) {
                                $who = "CEO/Municipal Office";
                              }
                              if ($logged_user['user_type_id'] == 11) {
                                $who = "CFO";
                              }
                              if ($logged_user['user_type_id'] == 10) {
                                $who = "CEO/Municipal manager";
                              }
                              if ($logged_user['user_type_id'] == 13) {
                                $who = "CFO Office";
                              }
                              if ($logged_user['user_type_id'] == 12) {
                                $who = "CEO/Municipal Office";
                              }
                              if ($logged_user['user_type_id'] == 25) {
                                $who = "Council Support Officer ";
                              }

                          if($who == '')
                          {
                            $who = $logged_user['UserType']['name'];
                          }

                        $message = "Welcome you are logged in as ".$who." | ".$logged_user['fname'].' '.$logged_user['sname'];

                        if($logged_user['id'] == 156)
                        {
                           $message = "Councillor ".$logged_user['fname'].' '.$logged_user['sname']." Welcome to Matjhabeng Local Municipality Electronic Council Documents";
                        }

                        if($logged_user['id'] == 120)
                        {
                           $message = "Welcome ".$logged_user['fname'].' '.$logged_user['sname']." you are logged in as the Admin Manager in Municipal Manager's office";
                        }

                        ?>
                <b><?php echo $message ?> </b>
                <?php


                            } else {
                        //print_r($logged_user);
                          $user_id = $logged_user['id'];

                              $greeting = '<b>';
                $displayed = 0;

                if($user_id == 31)
                {
                $greeting .= "Mr. Tsoaeli, the acting Municipal Manager, Welcome ";
                $displayed = 1;
                }

                if($user_id == 37)
                {
                $greeting .= "Mr. Makofane, the Executive Director SSS, Welcome  ";
                $displayed = 1;
                }

                if($user_id == 32)
                {
                $greeting .= "Mr. Wetes, the Executive Director CSS, Welcome ";
                $displayed = 1;
                }

                if($user_id == 34)
                {
                $greeting .= "Mr. Atolo, Senior Manager Council Admin, Welcome  ";
                $displayed = 1;
                }

                if($user_id == 38)
                {
                $greeting .= "Mrs. Mothekhe, the acting Executive Director LED & Planning, Welcome ";
                $displayed = 1;
                }

                if($user_id == 26)
                {
                $greeting .= "Ms. Williams, the acting CFO, Welcome ";
                $displayed = 1;
                }

                if($user_id == 118)
                {
                $greeting .= "Mr. L. Rubulana, the Snr. Manager: Office of the Speaker, Welcome  ";
                $displayed = 1;
                }

                if($user_id == 28)
                {
                $greeting .= "Cllr. Stofile, the Honourable Speaker, Welcome  ";
                $displayed = 1;
                }

                if($user_id == 27)
                {
                $greeting .= "Cllr. Speelman, the Honourable Executive Mayor, Welcome  ";
                $displayed = 1;
                }

                if($user_id == 29)
                {
                $greeting .= "Cllr. Sephiri, the Honourable Chief Whip, Welcome ";
                $displayed = 1;
                }

                if($user_id == 33)
                {
                $greeting .= "Ms. Ramakhale, the acting Manager Council Admin, Welcome ";
                $displayed = 1;
                }

                if($user_id == 39)
                {
                $greeting .= "Mrs. Maswanganyi, the Executive Director Infrastructure, Welcome ";
                $displayed = 1;
                }

                if($user_id == 30)
                {
                $greeting .= "Mrs. Seleka, Welcome ";
                $displayed = 1;
                }

                if($user_id == 36)
                {
                $greeting .= "Cllr. Morris, the Honourable MMC, Welcome ";
                $displayed = 1;
                }

                if($user_id == 116)
                {
                $greeting .= "Poncho Kodisang manager ICT, Welcome ";
                $displayed = 1;
                }

                if($user_id == 119)
                {
                $greeting .= "Joseph Molawa Acting Executive Director, Welcome ";
                $displayed = 1;
                }

                if($user_id == 120)
                {
                $greeting .= "Manager in Municipal Manager's office, Welcome ";
                $displayed = 1;
                }

                if($user_id == 121)
                {
                $greeting .= "Mr Martins Chief of staff, Welcome ";
                $displayed = 1;
                }

                if($user_id == 122)
                {
                $greeting .= "Personal assistant to executive mayor, Welcome ";
                $displayed = 1;
                }

                if($user_id == 123)
                {
                $greeting .= "Personal assistant to the speaker, Welcome ";
                $displayed = 1;
                }

                if($user_id == 124)
                {
                $greeting .= "Personal assistant to the chief whip, Welcome ";
                $displayed = 1;
                }

                if($displayed == 0)
                {
                $greeting .= $logged_user['UserType']['name']. " ".$logged_user['fname']." ".$logged_user['sname']." Welcome ";
                }

                if ($logged_user['user_type_id'] == 21) {
                $greeting = "MMC Support Officer, Welcome ";
                }

                if ($logged_user['user_type_id'] == 22) {
                $greeting = "Secretary of Strategic Support Services, Welcome ";
                }

                if ($logged_user['user_type_id'] == 23) {
                $greeting = "Secretary of Strategic Support Services, Welcome ";
                }

                if ($logged_user['user_type_id'] == 24) {
                $greeting = "Secretary of Corporate Support Services, Welcome ";
                }

                if ($logged_user['user_type_id'] == 25) {
                $greeting = "Council Support Officer, Welcome ";
                }

                echo $greeting." to Matjhabeng Local Municipality Electronic Council Documents</b>";

                }

                ?>

                </p>
                <div class="actions">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <ul class="nav nav-pills nav-stacked">
                                <?php if( in_array(21, $permissions) ):?>
                                <li style="<?php if($controller == 'Documents'){ echo 'background:#658B6E';} ?>" >
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('OFFICIAL DOCUMENTS'), array('controller' => 'Documents', 'action' => 'index'), array('escape' => false)); ?></li>
                                <?php endif?>
                                <?php if( in_array(2, $permissions) ):?>
                                 <li style="<?php if($controller == 'CounsilorDocuments'){ echo 'background:#658B6E';} ?>">
                                   <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('COUNCIL'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false, 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown')); ?>
                                     <ul class="dropdown-menu" role="menu" style="background-color: #2F575D">

                                        <li style="<?php if($controller == 'Notices'){ echo 'background:#658B6E';} ?>">
                                          <?php echo $this->html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('Council Meeting Documents'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?>
                                        </li>
                                        <?php if( in_array(161, $permissions) ):?>
                                         <li style="<?php if($controller == 'Notices'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;'.__('Councillors Notices'), array('controller' => 'Notices', 'action' => 'index'), array('escape' => false)); ?> </li>
                                         <?php endif?>

                                    </ul>
                                </li>
                                <?php endif; ?>

                                <?php if( in_array(1, $permissions) ):?>
                                <li style="<?php if($controller == 'MaycoDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO COMMITTEE MEETINGS DOCUMENTS'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                <?php endif ?>

                                <?php if( in_array(3, $permissions) ):?>
                                <li style="<?php if($controller == 'ExcoDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('EXCO COMMITTEE MEETINGS DOCUMENTS'), array('controller' => 'ExcoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                <?php endif?>

                                 <?php if( in_array(82, $permissions) ):?>
                                  <li style="<?php if($controller == 'RiskDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('RISK COMMITTEE MEETINGS DOCUMENTS'), array('controller' => 'RiskDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                 <?php endif ?>

                                <?php if( in_array(18, $permissions) ):?>
                                <li style="<?php if($controller == 'PublicSafityDocuments' || $controller == 'InfrastructureTechnicalServices' || $controller == 'IdpPolicyMonitoringDocuments' || $controller == 'CorporateServicesDocuments' || $controller == 'EightyDocuments' || $controller == 'FinanceDocuments' || $controller == 'CommunityServices'){ echo 'background:#658B6E';} ?>">
                                    <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('SECTION 80 COMMITTEES MEETINGS DOCUMENTS'), array('controller' => 'EightyDocuments', 'action' => 'index'), array('escape' => false, 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown')); ?>
                                    <ul class="dropdown-menu" role="menu" style="background-color: #2F575D">

                                        <?php if( in_array(4, $permissions) ):?>
                                        <li style="<?php if($controller == 'FinanceDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-bank"></span>&nbsp;&nbsp;'.__('Finance Committee'), array('controller' => 'FinanceDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(5, $permissions) ):?>
                                        <li style="<?php if($controller == 'InfrastructureTechnicalServices'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-road"></span>&nbsp;&nbsp;'.__('Infrastructure & Technical Services Committee'), array('controller' => 'InfrastructureTechnicalServices', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(6, $permissions) ):?>
                                        <li style="<?php if($controller == 'CommunityServices'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;'.__('Community Services Committee'), array('controller' => 'CommunityServices', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(7, $permissions) ):?>
                                        <li style="<?php if($controller == 'PublicSafityDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;'.__('Public Safety Committee'), array('controller' => 'PublicSafityDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(8, $permissions) ):?>
                                        <li style="<?php if($controller == 'EightyDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;'.__('Joint Section 80 Committee: LED, Tourism & Human Settlement'), array('controller' => 'EightyDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(10, $permissions) ):?>
                                        <li style="<?php if($controller == 'SpotsArtsCultureDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-hourglass"></span>&nbsp;&nbsp;'.__('Sports, Arts & Culture Committee'), array('controller' => 'SpotsArtsCultureDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(11, $permissions) ):?>
                                        <li style="<?php if($controller == 'CorporateServicesDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-tower"></span>&nbsp;&nbsp;'.__('Corporate Services Committee'), array('controller' => 'CorporateServicesDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(13, $permissions) ):?>
                                        <li style="<?php if($controller == 'IdpPolicyMonitoringDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-folder-close"></span>&nbsp;&nbsp;'.__('IDP, Policy, Monitoring & Evaluation Committee'), array('controller' => 'IdpPolicyMonitoringDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(53, $permissions) ):?>
                                        <li style="<?php if($controller == 'IdpPolicyMonitoringDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-folder-close"></span>&nbsp;&nbsp;'.__('Led, Small Business, Spatial Planning and Land Use Management'), array('controller' => 'LedDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(56, $permissions) ):?>
                                        <li style="<?php if($controller == 'IdpPolicyMonitoringDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-folder-close"></span>&nbsp;&nbsp;'.__('Human Settlement Committee'), array('controller' => 'HumanDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(59, $permissions) ):?>
                                        <li style="<?php if($controller == 'IdpPolicyMonitoringDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-folder-close"></span>&nbsp;&nbsp;'.__('Tourism, Environment Affairs and Agriculture Committee'), array('controller' => 'TourismDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(167, $permissions) ):?>
                                        <li style="<?php if($controller == 'SpecialPrograms'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-folder-close"></span>&nbsp;&nbsp;'.__('Special Programs'), array('controller' => 'SpecialPrograms', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                    </ul>

                                </li>
                                <?php endif?>

                                <?php if( in_array(74, $permissions) ):?>
                                <li style="<?php if($controller == 'AuditDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Audit Committee'), array('controller' => 'AuditDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                <?php endif?>

                                <?php if( in_array(19, $permissions) ):?>
                                <li style="<?php if($controller == 'SeventyNineDocuments' || $controller == 'MpacDocuments' || $controller == 'DisputeResolutionDocuments' || $controller == 'RulesDocuments'){ echo 'background:#658B6E';} ?>">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('SECTION 79 COMMITTEES MEETINGS DOCUMENTS'), array('controller' => 'SeventyNineDocuments', 'action' => 'index'), array('escape' => false, 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown')); ?>
                                    <ul class="dropdown-menu" role="menu" style="background-color: #2F575D">

                                        <?php if( in_array(62, $permissions) ):?>
                                        <li style="<?php if($controller == 'ChairDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Chair of Chairs Committee'), array('controller' => 'ChairDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(70, $permissions) ):?>
                                        <li style="<?php if($controller == 'DermacationDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Dermacation Committee'), array('controller' => 'DermacationDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(15, $permissions) ):?>
                                        <li style="<?php if($controller == 'DisputeResolutionDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-adjust"></span>&nbsp;&nbsp;'.__('Dispute Resolution Committee'), array('controller' => 'DisputeResolutionDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(14, $permissions) ):?>
                                        <li style="<?php if($controller == 'MpacDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MPAC Committee'), array('controller' => 'MpacDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(65, $permissions) ):?>
                                        <li style="<?php if($controller == 'PoliticalDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Political Steering Committee'), array('controller' => 'PoliticalDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(71, $permissions) ):?>
                                        <li style="<?php if($controller == 'RevenueDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Revenue Enhancement Committee Meeting'), array('controller' => 'RevenueDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                        <?php if( in_array(16, $permissions) ):?>
                                        <li style="<?php if($controller == 'RulesDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Rules Committee'), array('controller' => 'RulesDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                        <?php endif?>

                                    </ul>
                                </li>
                                <?php endif?>
                                <?php if( in_array(78, $permissions) ):?>
                                <li style="<?php if($controller == 'AdhocCommittees'){ echo 'background:#658B6E';} ?>">
                                <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('TEMPORARY COMMITTEES'), array('controller' => 'TemporaryCommittees', 'action' => 'index'), array('escape' => false, 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown')); ?>
                                        <ul class="dropdown-menu" role="menu" style="background-color: #2F575D">

                                            <?php if( in_array(79, $permissions) ):?>
                                            <li style="<?php if($controller == 'AdhocCommittees'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('ADHOC Committee'), array('controller' => 'AdhocCommittees', 'action' => 'index'), array('escape' => false)); ?> </li>
                                            <?php endif?>
                                        </ul>
                                <?php endif?>
                                <?php if( in_array(20, $permissions) ):?>
                                <li style="height: 61px !important;<?php if($controller == 'Llfdocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('LLF MEETING DOCUMENTS'), array('controller' => 'Llfdocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                                <?php endif?>

                                <?php if( in_array(17, $permissions) ):?>
                                <li style="<?php if($controller == 'Users'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('USERS'), array('controller' => 'Users', 'action' => 'index'), array('escape' => false)); ?> </li>
                                <?php endif?>
                                <li><a href="/users/myprofile"><span class="glyphicon glyphicon-user"></span><?php echo __('MY PROFILE') ?></a></li>

                                <li><a href="/users/logout"><span class="glyphicon glyphicon-user"></span><?php echo __('LOGOUT') ?></a></li>
                            </ul>

                        </div><!-- end panel -->
                    </div><!-- end actions -->
            </td>
        </tr>
        <?php endif;?>
    </table>

</div>
<script type='text/javascript'>

  (function()
  {
    if( window.localStorage )
    {
      if( !localStorage.getItem('firstLoad') )
      {
        localStorage['firstLoad'] = true;
        window.location.reload();
      }
      else
        localStorage.removeItem('firstLoad');
    }
  })();

</script>
