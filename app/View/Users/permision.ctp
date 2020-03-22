<div class="users ">
  <?php echo $this->Form->create('User', array('ation' => 'permision')); ?>
  <h4><?php echo __('Set Permision for '.$user['User']['fname'].' '.$user['User']['sname'].' ('.$user['UserType']['name'].' )'); ?></h4>
  <table cellpadding="0" cellspacing="0" class="table-striped">
    <tr>
      <th><?php echo __('Permission name'); ?></th>
      <th><?php echo __('View'); ?></th>
      <th><?php echo __('Scriber'); ?></th>
      <th><?php echo __('Capture<br />Minutes'); ?></th>
      <th><?php echo __('Executive<br />Director'); ?></th>
      <th><?php echo __('Funds<br />Verification'); ?></th>
      <th><?php echo __('Manager<br />SCM'); ?></th>
      <th><?php echo __('CFO'); ?></th>
  </tr>
    <tr>
    <?php echo $this->Form->input('id', array('value' => $user['User']['id'], 'type' => 'hidden')) ?>
      <td><?php echo __('View'); ?> Mayco Documents</td>
      <td align='center'><input type="checkbox" <?php if( in_array(1, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="1" id="UserPermissions1"></td>
      <td align='center'><input type="checkbox" <?php if( in_array(22, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="22" id="UserPermissions22"></td>
      <td align='center'><input type="checkbox" <?php if( in_array(38, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="38" id="UserPermissions38"></td>
      <td align='center'><input type="checkbox" <?php if( in_array(106, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="106" id="UserPermissions106"></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td><?php echo __('View'); ?> Council Documents</td>
      <td align='center'><input type="checkbox" <?php if( in_array(2, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="2" id="UserPermissions2"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(23, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="23" id="UserPermissions23"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(39, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="39" id="UserPermissions39"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(105, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="105" id="UserPermissions105"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td><?php echo __('View'); ?> Council Notices</td>
      <td align='center'><input type="checkbox" <?php if( in_array(161, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="161" id="UserPermissions161"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(164, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="164" id="UserPermissions164"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(165, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="165" id="UserPermissions165"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(166, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="166" id="UserPermissions166"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td><?php echo __('View'); ?> EXCO Documents</td>
      <td align='center'><input type="checkbox" <?php if( in_array(3, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="3" id="UserPermissions3"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(24, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="24" id="UserPermissions24"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(40, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="40" id="UserPermissions40"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(104, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="104" id="UserPermissions104"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
        <td>LLF MEETING DOCUMENTS</td>
        <td align='center'><input type="checkbox" <?php if( in_array(20, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="20" id="UserPermissions20"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(25, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="25" id="UserPermissions25"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(41, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="41" id="UserPermissions41"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(103, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="103" id="UserPermissions103"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>RISK MANAGEMENT COMMITEE MEETING DOCUMENTS</td>
        <td align='center'><input type="checkbox" <?php if( in_array(82, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="82" id="UserPermissions82"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(83, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="83" id="UserPermissions83"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(84, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="84" id="UserPermissions84"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(102, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="102" id="UserPermissions102"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>PRE APPROVAL OVERTIME</td>
        <td align='center'><input type="checkbox" <?php if( in_array(154, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="154" id="UserPermissions154"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(155, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="155" id="UserPermissions155"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(156, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="156" id="UserPermissions156"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(157, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="157" id="UserPermissions157"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>OVERTIME</td>
        <td align='center'><input type="checkbox" <?php if( in_array(138, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="138" id="UserPermissions138"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(139, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="139" id="UserPermissions139"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(140, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="140" id="UserPermissions140"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(141, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="141" id="UserPermissions141"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>SALARIES</td>
        <td align='center'><input type="checkbox" <?php if( in_array(142, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="142" id="UserPermissions142"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(143, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="143" id="UserPermissions143"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(144, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="144" id="UserPermissions144"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(145, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="145" id="UserPermissions145"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
   <tr>
      <td colspan="8"><h4>SECTION 80 COMMITTEES <input type="checkbox" <?php if( in_array(18, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="18" id="UserPermissions18"> </h4></td>
    </tr>
    <tr>
      <td>FINANCE COMMITTEE</td>
      <td align='center'><input type="checkbox" <?php if( in_array(4, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="4" id="UserPermissions4"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(27, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="27" id="UserPermissions27"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(42, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="42" id="UserPermissions42"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(101, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="101" id="UserPermissions101"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>INFRASTRUCTURE & TECHNICAL SERVICES COMMITTEE
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(5, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="5" id="UserPermissions5"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(28, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="28" id="UserPermissions28"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(43, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="43" id="UserPermissions43"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(100, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="100" id="UserPermissions100"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>COMMUNITY SERVICES COMMITTEE
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(6, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="6" id="UserPermissions6"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(29, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="29" id="UserPermissions29"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(44, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="44" id="UserPermissions44"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(99, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="99" id="UserPermissions99"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>PUBLIC SAFETY AND TRANSPORT COMMITTEE
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(7, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="7" id="UserPermissions7"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(30, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="30" id="UserPermissions30"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(45, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="45" id="UserPermissions45"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(98, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="98" id="UserPermissions98"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>JOINT SECTION 80 COMMITTEE: LED, TOURISM & HUMAN SETTLEMENT
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(8, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="8" id="UserPermissions8"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(31, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="31" id="UserPermissions31"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(46, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="46" id="UserPermissions46"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(97, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="97" id="UserPermissions97"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>SPORT, ARTS & CULTURE COMMITTEE
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(10, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="10" id="UserPermissions10"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(32, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="32" id="UserPermissions32"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(47, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="47" id="UserPermissions47"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(96, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="96" id="UserPermissions96"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>CORPORATE SERVICES COMMITTEE
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(11, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="11" id="UserPermissions11"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(33, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="33" id="UserPermissions33"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(48, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="48" id="UserPermissions48"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(95, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="95" id="UserPermissions95"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>IDP, POLICY, MONITORING & EVALUATION COMMITTEE
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(13, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="13" id="UserPermissions13"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(34, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="34" id="UserPermissions34"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(49, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="49" id="UserPermissions49"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(94, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="94" id="UserPermissions94"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
        <td>LED, SMALL BUSINESS, SPATIAL PLANNING AND LAND USE MANAGEMENT</td>
        <td align='center'><input type="checkbox" <?php if( in_array(53, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="53" id="UserPermissions53"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(54, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="54" id="UserPermissions54"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(55, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="55" id="UserPermissions55"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(93, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="93" id="UserPermissions93"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>HUMAN SETTLEMENT COMMITTEE</td>
        <td align='center'><input type="checkbox" <?php if( in_array(56, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="56" id="UserPermissions56"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(57, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="57" id="UserPermissions57"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(58, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="58" id="UserPermissions58"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(92, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="92" id="UserPermissions92"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>TOURISM, ENVIRONMENT AFFAIRS AND AGRICULTURE COMMITTEE</td>
        <td align='center'><input type="checkbox" <?php if( in_array(59, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="59" id="UserPermissions59"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(60, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="60" id="UserPermissions60"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(61, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="61" id="UserPermissions61"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(91, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="91" id="UserPermissions91"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>SPECIAL PROGRAMS</td>
        <td align='center'><input type="checkbox" <?php if( in_array(167, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="167" id="UserPermissions167"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(168, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="168" id="UserPermissions168"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(169, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="169" id="UserPermissions169"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(170, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="170" id="UserPermissions170"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
      <td colspan="8"><h4>SECTION 79 COMMITTEES <input type="checkbox" <?php if( in_array(19, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="19" id="UserPermissions19"> </h4></td>
    </tr>
    <tr>
      <td>MPAC COMMITTEE</td>
      <td align='center'><input type="checkbox" <?php if( in_array(14, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="14" id="UserPermissions14"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(35, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="35" id="UserPermissions35"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(50, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="50" id="UserPermissions50"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(90, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="90" id="UserPermissions90"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>DISPUTE RESOLUTION COMMITTEE </td>
      <td align='center'><input type="checkbox" <?php if( in_array(15, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="15" id="UserPermissions15"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(36, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="36" id="UserPermissions36"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(51, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="51" id="UserPermissions51"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(89, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="89" id="UserPermissions89"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>RULES COMMITTEE
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(16, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="16" id="UserPermissions16"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(37, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="37" id="UserPermissions37"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(52, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="52" id="UserPermissions52"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(88, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="88" id="UserPermissions88"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
        <td>CHAIR OF CHAIRS DOCUMENTS</td>
        <td align='center'><input type="checkbox" <?php if( in_array(62, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="62" id="UserPermissions62"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(63, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="63" id="UserPermissions63"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(64, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="64" id="UserPermissions64"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(87, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="87" id="UserPermissions87"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>POLITICAL STEERING COMMITTEE</td>
        <td align='center'><input type="checkbox" <?php if( in_array(65, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="65" id="UserPermissions65"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(66, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="66" id="UserPermissions66"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(67, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="67" id="UserPermissions67"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(86, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="86" id="UserPermissions86"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>DERMACATION COMMITTEE</td>
        <td align='center'><input type="checkbox" <?php if( in_array(68, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="68" id="UserPermissions68"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(69, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="69" id="UserPermissions69"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(70, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="70" id="UserPermissions70"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(85, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="85" id="UserPermissions85"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>REVENUE ENHANCEMENT COMMITTEE</td>
        <td align='center'><input type="checkbox" <?php if( in_array(71, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="71" id="UserPermissions71"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(72, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="72" id="UserPermissions72"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(73, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="73" id="UserPermissions73"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(107, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="107" id="UserPermissions107"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>AUDIT COMMITTEE</td>
        <td align='center'><input type="checkbox" <?php if( in_array(74, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="74" id="UserPermissions74"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(75, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="75" id="UserPermissions75"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(76, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="76" id="UserPermissions76"> </td>
        <td align='center'><input type="checkbox" <?php if( in_array(109, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="109" id="UserPermissions109"> </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
      <td colspan="8"><h4>TEMPORARY COMMITTEE<input type="checkbox" <?php if( in_array(78, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="78" id="UserPermissions78"> </h4></td>
    </tr>
    <tr>
      <td>ADHOC COMMITTEE</td>
      <td align='center'><input type="checkbox" <?php if( in_array(79, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="79" id="UserPermissions79"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(80, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="80" id="UserPermissions80"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(81, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="81" id="UserPermissions81"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(108, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="108" id="UserPermissions108"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8"><h4>DASHBOARD <input type="checkbox" <?php if( in_array(77, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="77" id="UserPermissions77"> </h4></td>
    </tr>
    <tr>
      <td>MANAGE USERS
      </td>
      <td align='center'><input type="checkbox" <?php if( in_array(17, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="17" id="UserPermissions17"> </td>
      <td align='center'><b>Municipal manager</b>&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php if( in_array(113, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="113" id="UserPermissions113"> </td>
      <td align='center'><b>Create Departments</b>&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php if( in_array(162, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="162" id="UserPermissions162"> </td>
      <td align='center'><b>Create Sections</b>&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php if( in_array(163, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="163" id="UserPermissions163"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8"><h4>OFFICIAL DOCUMENTS by DEPARTMENTS&nbsp;&nbsp;&nbsp;<input type="checkbox" <?php if( in_array(21, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="21" id="UserPermissions21"> </h4></td>
    </tr>
    <tr>
      <td>INFRASTRUCTURE</td>
      <td align='center'><input type="checkbox" <?php if( in_array(114, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="114" id="UserPermissions114"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(115, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="115" id="UserPermissions115"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(116, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="116" id="UserPermissions116"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 6) {
              if($vl['name']):
                ?>
                <p style="width:120px; float:left"><?php echo $vl['name']?>
                  <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                </p>
                <?php
             endif;
            }
          }?>
      </td>
    </tr>
    <tr>
      <td>CORPORATE SUPPORT SERVICES</td>
      <td align='center'><input type="checkbox" <?php if( in_array(117, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="117" id="UserPermissions117"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(118, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="118" id="UserPermissions118"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(119, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="119" id="UserPermissions119"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 1) {
              foreach($value['DepartmentSection'] as $vl):
                if($vl['name']):
                  ?>
                  <p style="width:120px; float:left"><?php echo $vl['name']?>
                    <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                  </p>
                <?php
               endif;
             endforeach;
            }
          }?>
      </td>
    </tr>
    <tr>
      <td>COMMUNITY SERVICES</td>
      <td align='center'><input type="checkbox" <?php if( in_array(120, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="120" id="UserPermissions120"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(121, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="121" id="UserPermissions121"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(122, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="122" id="UserPermissions122"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 5) {
              foreach($value['DepartmentSection'] as $vl):
                if($vl['name']):
                  ?>
                  <p style="width:120px; float:left"><?php echo $vl['name']?>
                    <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                  </p>
                <?php
               endif;
             endforeach;
            }
          }?>
      </td>
    </tr>
    <tr>
      <td>LED</td>
      <td align='center'><input type="checkbox" <?php if( in_array(123, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="123" id="UserPermissions123"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(124, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="124" id="UserPermissions124"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(125, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="125" id="UserPermissions125"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 13) {
              foreach($value['DepartmentSection'] as $vl):
                if($vl['name']):
                  ?>
                  <p style="width:120px; float:left"><?php echo $vl['name']?>
                    <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                  </p>
                <?php
               endif;
             endforeach;
            }
          }?>
      </td>
    </tr>
    <tr>
      <td>FINANCE</td>
      <td align='center'><input type="checkbox" <?php if( in_array(126, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="126" id="UserPermissions126"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(127, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="127" id="UserPermissions127"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(128, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="128" id="UserPermissions128"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(110, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="110" id="UserPermissions110"></td>
      <td align='center'><input type="checkbox" <?php if( in_array(111, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="111" id="UserPermissions111"></td>
      <td align='center'><input type="checkbox" <?php if( in_array(112, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="112" id="UserPermissions112"></td>
    </tr>
    <tr>
    <tr>
      <td>SECTIONS MESSAGES</td>
      <td align='center'><input type="checkbox" <?php if( in_array(146, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="146" id="UserPermissions126"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(147, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="147" id="UserPermissions127"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(148, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="148" id="UserPermissions128"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(149, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="149" id="UserPermissions110"></td>
      <td align='center'><input type="checkbox" <?php if( in_array(150, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="150" id="UserPermissions111"></td>
      <td align='center'><input type="checkbox" <?php if( in_array(151, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="151" id="UserPermissions112"></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 3) {
              foreach($value['DepartmentSection'] as $vl):
                if($vl['name']):
                  ?>
                  <p style="width:120px; float:left"><?php echo $vl['name']?>
                    <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                  </p>
                <?php
               endif;
             endforeach;
            }
          }?>
      </td>
    </tr>
    <tr>
      <td>STRATEGIC SUPPORT SERVICES</td>
      <td align='center'><input type="checkbox" <?php if( in_array(129, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="129" id="UserPermissions129"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(130, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="130" id="UserPermissions130"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(131, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="131" id="UserPermissions131"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 7) {
              foreach($value['DepartmentSection'] as $vl):
                if($vl['name']):
                  ?>
                  <p style="width:120px; float:left"><?php echo $vl['name']?>
                    <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                  </p>
                <?php
               endif;
             endforeach;
            }
          }?>
      </td>
    </tr>
    <tr>
      <td>MAYOR'S OFFICE</td>
      <td align='center'><input type="checkbox" <?php if( in_array(132, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="132" id="UserPermissions132"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(133, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="133" id="UserPermissions133"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(134, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="134" id="UserPermissions134"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 8) {
              foreach($value['DepartmentSection'] as $vl):
                if($vl['name']):
                  ?>
                  <p style="width:120px; float:left"><?php echo $vl['name']?>
                    <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                  </p>
                <?php
               endif;
             endforeach;
            }
          }?>
      </td>
    </tr>
    <tr>
      <td>SPEAKER'S OFFICE</td>
      <td align='center'><input type="checkbox" <?php if( in_array(135, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="135" id="UserPermissions135"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(136, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="136" id="UserPermissions136"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(137, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="137" id="UserPermissions137"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 9) {
              foreach($value['DepartmentSection'] as $vl):
                if($vl['name']):
                  ?>
                  <p style="width:120px; float:left"><?php echo $vl['name']?>
                    <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                  </p>
                <?php
               endif;
             endforeach;
            }
          }?>
      </td>
    </tr>

    <tr>
      <td>LOCAL ECONOMIC DEVELOPMENT</td>
      <td align='center'><input type="checkbox" <?php if( in_array(158, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="158" id="UserPermissions135"> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(159, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="159" id="UserPermissions136"> </td>
      <td> </td>
      <td align='center'><input type="checkbox" <?php if( in_array(160, $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="160" id="UserPermissions137"> </td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <small style="clear:both"><b>Manager Units</b></small><br style='clear:both' />

          <?php foreach ($AllDepartments as $value) {
            if($value['Department']['id'] == 2) {
              foreach($value['DepartmentSection'] as $vl):
                if($vl['name']):
                  ?>
                  <p style="width:120px; float:left"><?php echo $vl['name']?>
                    <input type="checkbox" <?php if( in_array($vl['permission'], $user['User']['permissions']) ) { echo 'checked'; }?> name="data[User][permissions][]" style="margin:0 !important" value="<?php echo $vl['permission']?>" id="UserPermissions<?php echo $vl['permission']?>">
                  </p>
                <?php
               endif;
             endforeach;
            }
          }?>
      </td>
    </tr>
    <tr>
      <td colspan="8">
       <?php echo $this->Form->end(__('Set Permissions')); ?>
      </td>
    </tr>
  </table>
</div>
