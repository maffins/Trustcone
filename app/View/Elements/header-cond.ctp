<div class="page-heade" style="padding: 0 !important;align-content: center">
   <style>
       .nav-stacked > li {
            float: left !important;
       }
       .panel-heading {
           padding: 0 !important;
       }
   </style>

<?php
    $logged_user = AuthComponent::user();
    $permissions = unserialize($logged_user['permissions']);
    $controller = $this->params['controller'];
?>
     <table style="width: 75%;margin: 0 auto">
          <tr>
               <td></td>
               <td style="vertical-align: text-top;text-align: center">
                   <table width="100%">
                       <tr>
                           <td><img alt="matjhabeng local municipality" src="/app/webroot/img/matjhabeng2.png" border="0"></td>
                           <?php if(!AuthComponent::user()):?>
                               <style>
                                       h1 {
                                           font-size: 27px !important;
                                       }
                               </style>
                           <?php endif;?>
                           <td style="text-align: center;padding: 0">
                               <h1>Matjhabeng Local Municipality <br />Document Management System </h1>

                           </td>
                           <td><img alt="matjhabeng local municipality" src="/app/webroot/img/matjhabeng2.png" border="0"></td>
                       </tr>
                   </table>
               </td>
          <td></td>
          </tr>
     <?php if(AuthComponent::user()):?>
        <tr>
            <td colspan="3" style="text-align: center;vertical-align: text-top">
                <?php

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
                    $greeting .= "Welcome Councillor Mr. Tsoaeli";
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

                if($user_id == 156)
                {
                $greeting .= "Councillor ";
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
                <?php
                    $allControllers['CounsilorDocuments'] = 0;
                    $allControllers['MaycoDocuments'] = 1;
                    $allControllers['ExcoDocuments'] = 2;
                    $allControllers['FinanceDocuments'] = 8;
                    $allControllers['InfrastructureTechnicalServices'] = 7;
                    $allControllers['CommunityServices'] = 4;
                    $allControllers['PublicSafityDocuments'] = 9;
                    $allControllers['EightyDocuments'] = 3;
                    $allControllers['SpotsArtsCultureDocuments'] = 10;
                    $allControllers['CorporateServicesDocuments'] = 5;
                    $allControllers['IdpPolicyMonitoringDocuments'] = 6;
                    $allControllers['MpacDocuments'] = 11;
                    $allControllers['DisputeResolutionDocuments'] = 13;
                    $allControllers['RulesDocuments'] = 12;
                    $allControllers['HumanDocuments'] = 15;
                    $allControllers['LedDocuments'] = 16;
                    $allControllers['TourismDocuments'] = 14;
                    $allControllers['ChairDocuments'] = 17;
                    $allControllers['AuditDocument'] = 18;
                    $allControllers['DermacationDocument'] = 19;
                    $allControllers['PoliticalDocument'] = 20;
                    $allControllers['RevenueDocument'] = 21;
                    $allControllers['AdhocCommittee'] = 22;
                    $allControllers['RiskDocument'] = 23;
                    $allControllers['Notices'] = 24;
                    $allControllers['LlfDocuments'] = 25;
                    $allControllers['SectionMessages'] = 146;



                ?>
                <div class="actions">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <ul class="nav nav-pills ">
                              <li style="<?php if($controller == 'Pages'){ echo 'background:#658B6E';} ?>" >
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('HOME'), array('controller' => 'pages', 'action' => 'home'), array('escape' => false)); ?>
                              </li>
                              <?php if( in_array(21, $permissions) && $controller == 'Documents' ):?>
                              <li style="<?php if($controller == 'Documents'){ echo 'background:#658B6E';} ?>" >
                                  <?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('OFFICIAL DOCUMENTS'), array('controller' => 'Documents', 'action' => 'index'), array('escape' => false)); ?></li>
                              <?php endif?>

                              <?php if( (in_array(2, $permissions) && $controller == 'CounsilorDocuments') || ( $type == 0 && $controller == 'MeetingMinutes') ):?>
                                  <li style="<?php if($controller == 'CounsilorDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('COUNCIL MEETINGS DOCUMENTS'), array('controller' => 'CounsilorDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                             <?php endif; ?>

                              <?php if( (in_array(1, $permissions) && $controller == 'MaycoDocuments') || ( $type == 1 && $controller == 'MeetingMinutes') ):?>
                               <li style="<?php if($controller == 'MaycoDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MAYCO COMMITTEE MEETINGS DOCUMENTS'), array('controller' => 'MaycoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif ?>

                              <?php if( (in_array(82, $permissions) && $controller == 'RiskDocuments') || ( $type == 23 && $controller == 'MeetingMinutes')):?>
                               <li style="<?php if($controller == 'RiskDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('RISK COMMITTEE MEETINGS DOCUMENTS'), array('controller' => 'RiskDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif ?>

                              <?php if( (in_array(3, $permissions) && $controller == 'ExcoDocuments') || ( $type == 2 && $controller == 'MeetingMinutes') ):?>
                                  <li style="<?php if($controller == 'ExcoDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('EXCO COMMITTEE MEETINGS DOCUMENTS'), array('controller' => 'ExcoDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif ?>

                              <?php if( (in_array(4, $permissions) && $controller == 'FinanceDocuments') || ( $type == 8 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'FinanceDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-euro"></span>&nbsp;&nbsp;'.__('FINANCE COMMITTEE MEETINGS DOCUMENTS'), array('controller' => 'FinanceDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(5, $permissions) && $controller == 'InfrastructureTechnicalServices') || ( $type == 7 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'InfrastructureTechnicalServices'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-road"></span>&nbsp;&nbsp;'.__('Infrastructure & Technical Services Committee'), array('controller' => 'InfrastructureTechnicalServices', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(6, $permissions) && $controller == 'CommunityServices') || ( $type == 4 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'CommunityServices'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;'.__('Community Services Section 80 Committee'), array('controller' => 'CommunityServices', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(7, $permissions) && $controller == 'PublicSafityDocuments') || ( $type == 9 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'PublicSafityDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;'.__('Public Safety Committee'), array('controller' => 'PublicSafityDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(8, $permissions) && $controller == 'EightyDocuments') || ( $type == 3 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'EightyDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;'.__('Joint Section 80 Committee: LED, Tourism & Human Settlement'), array('controller' => 'EightyDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(10, $permissions) && $controller == 'SpotsArtsCultureDocuments') || ( $type == 10 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'SpotsArtsCultureDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-hourglass"></span>&nbsp;&nbsp;'.__('Sports, Arts & Culture Committee'), array('controller' => 'SpotsArtsCultureDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(11, $permissions) && $controller == 'CorporateServicesDocuments') || ( $type == 5 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'CorporateServicesDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-tower"></span>&nbsp;&nbsp;'.__('Corporate Services Section 80 Committee'), array('controller' => 'CorporateServicesDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(13, $permissions) && $controller == 'IdpPolicyMonitoringDocuments') || ( $type == 6 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'IdpPolicyMonitoringDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-folder-close"></span>&nbsp;&nbsp;'.__('IDP, Policy, Monitoring & Evaluation Committee'), array('controller' => 'IdpPolicyMonitoringDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(53, $permissions) && $controller == 'LedDocuments') || ( $type == 16 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'SpotsArtsCultureDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-hourglass"></span>&nbsp;&nbsp;'.__('LED, SMALL BUSINESS, SPATIAL PLANNING AND LAND USE MANAGEMENT'), array('controller' => 'SpotsArtsCultureDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(56, $permissions) && $controller == 'HumanDocuments') || ( $type == 15 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'CorporateServicesDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-tower"></span>&nbsp;&nbsp;'.__('HUMAN SETTLEMENT COMMITEE'), array('controller' => 'CorporateServicesDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(59, $permissions) && $controller == 'TourismDocuments') || ( $type == 14 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'IdpPolicyMonitoringDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-folder-close"></span>&nbsp;&nbsp;'.__('TOURISM, ENVIRONMENT AFFAIRS AND AGRICULTURE COMMITEE'), array('controller' => 'IdpPolicyMonitoringDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(14, $permissions) && $controller == 'MpacDocuments') || ( $type == 11 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'MpacDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyph icon glyphicon-list"></span>&nbsp;&nbsp;'.__('MPAC Committee'), array('controller' => 'MpacDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(15, $permissions) && $controller == 'DisputeResolutionDocuments') || ( $type == 13 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'DisputeResolutionDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-adjust"></span>&nbsp;&nbsp;'.__('Dispute Resolution Committee'), array('controller' => 'DisputeResolutionDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(16, $permissions) && $controller == 'RulesDocuments') || ( $type == 12 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'RulesDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Rules Committee'), array('controller' => 'RulesDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(64, $permissions) && $controller == 'ChairDocuments') || ( $type == 17 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'ChairDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Chair of Chairs'), array('controller' => 'ChairDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(67, $permissions) && $controller == 'PoliticalDocuments') || ( $type == 20 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'PoliticalDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Political Steering Committee'), array('controller' => 'PoliticalDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(70, $permissions) && $controller == 'DermacationDocuments') || ( $type == 19 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'DermacationDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Dermacation Committee'), array('controller' => 'DermacationDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(73, $permissions) && $controller == 'RevenueDocuments') || ( $type == 21 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'RevenueDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Revenue Enhancement'), array('controller' => 'RevenueDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( (in_array(76, $permissions) && $controller == 'AuditDocuments') || ( $type == 18 && $controller == 'MeetingMinutes') ):?>
                              <li style="<?php if($controller == 'AuditDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;'.__('Audit Committee'), array('controller' => 'AuditDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                              <?php if( in_array(20, $permissions) && $controller == 'LlfDocuments' ):?>
                                  <li style="height: 61px !important;<?php if($controller == 'LlfDocuments'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('LLF MEETING DOCUMENTS'), array('controller' => 'LlfDocuments', 'action' => 'index'), array('escape' => false)); ?> </li>
                              <?php endif?>

                            <?php if( in_array(146, $permissions) ):?>
                            <li style="<?php if($controller == 'SectionMessages'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-folder-close"></span>&nbsp;&nbsp;'.__('SECTION MESSAGES'), array('controller' => 'SectionMessages', 'action' => 'index'), array('escape' => false)); ?> </li>
                            <?php endif?>

                                <?php if( in_array(17, $permissions) ):?>
                                <?php

                                    if($allControllers[$controller])
                                    {
                                        $type = $allControllers[$controller];
                                    } else {
                                        $type = 0;
                                    }
                                ?>
                                <?php if($controller != "Documents"):?>
                                    <li style="<?php if($controller == 'MeetingMinutes'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('MINUTES'), array('controller' => 'MeetingMinutes', 'action' => 'index',$type), array('escape' => false)); ?> </li>
                                <?php endif ?>
                                <?php endif ?>
                                <?php if( in_array(17, $permissions) ):?>
                                <li style="<?php if($controller == 'Users'){ echo 'background:#658B6E';} ?>"><?php echo $this->Html->link('<span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;'.__('USERS'), array('controller' => 'Users', 'action' => 'index'), array('escape' => false)); ?> </li>
                                <?php endif ?>
                                <li><a href="#" onclick="goBack()"><span class="glyphicon glyphicon-user"></span><?php echo __('BACK')?></a></li>

                                <li><a href="/users/logout"><span class="glyphicon glyphicon-user"></span><?php echo __('LOGOUT')?></a></li>
                            </ul>
                        </div><!-- end panel -->
                    </div><!-- end actions -->
            </td>
        </tr>
      <?php endif;?>
     </table>

 </div>
<script type="application/javascript">

    $(document).ready(function() {
        $(".dropdown-toggle").dropdown();
    });

function goBack() {
    window.history.back();
}

</script>
<?php if ($this->action == 'login'):?>
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
<?php endif;?>
