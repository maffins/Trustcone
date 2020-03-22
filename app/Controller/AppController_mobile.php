<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controler', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  public $components = array(
        'DebugKit.Toolbar',
        'Flash',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'documents',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            )
        ));
    public function befoter() {
       //$this->Auth->allow('index', 'view');
        $this->layout = 'bootstrap';
    }

    function beforeFilter() {
        if ($this->request->is('mobile')) {
            $this->is_mobile = true;
            $this->set('is_mobile', true );
            $this->autoRender = false;
        }
    }

    function afterFilter() {
        // if in mobile mode, check for a valid view and use it

        if (isset($this->is_mobile) && $this->is_mobile) {

            $view_file = new File( '/app/View/' . $this->name . DS . 'mobile/' . $this->action . '.ctp' );
            $this->render($this->action, 'mobile', ($view_file->exists()?'mobile/':'').$this->action);
        }
    }

    public function udpateDocumentTrail() {
      App::uses('AppModel', 'DocumentsTracker');
    }
}
