<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Faults Controller
 *
 * @property Fault $Fault
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class FaultsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
	    //Need to put the user id so that can only see my reported faults
		if ($this->Auth->user()['user_type_id'] == 16)
        {
            $this->Fault->recursive = 0;
            $this->set('faults', $this->Paginator->paginate());
            $this->set('user_type_id', $this->Auth->user()['user_type_id']);
        } else {
            $this->paginate = [
                'conditions' => [
                    'Fault.user_id' => $this->Auth->user('id'),
                ]
            ];
            $this->set('faults', $this->paginate($this->Fault));
            $this->set('user_type_id', $this->Auth->user()['user_type_id']);
        }

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Fault->exists($id)) {
			throw new NotFoundException(__('Invalid fault'));
		}
		$options = array('conditions' => array('Fault.' . $this->Fault->primaryKey => $id));
		$this->set('fault', $this->Fault->find('first', $options));

        //Get the uploaded documents
        $this->loadModel('FaultsDocument');
        $options = array('conditions' => array('FaultsDocument.fault_id'  => $id));
        $this->set('FaultsDocument', $this->FaultsDocument->find('all', $options));

        //Get the comments added to this fault
        $this->loadModel('FaultsComment');
        $options = array('conditions' => array('FaultsComment.fault_id'  => $id));
        $this->set('FaultsComment', $this->FaultsComment->find('all', $options));

        $this->set('user_type_id', $this->Auth->user()['user_type_id']);
	}

    public function assign($fault_id)
    {
        if ($this->request->is('post')) {

            $fault_id = $this->request->data['Fault']['fault_id'];
            //print_r($this->request->data);die;
            $this->Fault->updateAll(['assigned_to' => "'".$this->request->data['Fault']['assigned_to']."'"], ['Fault.id' => $fault_id]);

            //Compose and email and send to the counsilor who reported the fault
            $Email = new CakeEmail();

            $this->loadModel('Fault');
            $options = array('conditions' => array('Fault.' . $this->Fault->primaryKey => $fault_id));
            $fault = $this->Fault->find('first', $options);

            $this->loadModel('User');
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $fault['User']['id']));
            $counsilor = $this->User->find('first', $options);

            $subject = "Someone has been assigned";
            //Send the notification to the logged in user.
            $Email->from(array('no-reply@lejweleputswa.com' => 'Matjhabeng Local Municipality Document Management System Faults'))
                ->template('assign', 'default')
                ->emailFormat('html')
                ->viewVars(array('assigned_to' => $this->request->data['Fault']['assigned_to']))
                ->to($counsilor['User']['email'])
                ->bcc('maffins@gmail.com')
                ->subject($subject)
                ->send();

            return $this->redirect(array('action' => 'view', 'controller' => 'Faults', $fault_id));
        }

        $this->set('fault_id', $fault_id);
    }

    public function completed($fault_id)
    {
        if ($this->request->is('post')) {

            echo date('Y-m-d');
            $completed['Fault']['id']             = $fault_id;
            $completed['Fault']['status']         = 7;
            $completed['Fault']['completed_date'] = date('Y-m-d');
            if (!$this->Fault->save($completed)){
            die('Die here');
           }
            //Compose and email and send to the counsilor who reported the fault
            $Email = new CakeEmail();

            $this->loadModel('Fault');
            $options = array('conditions' => array('Fault.' . $this->Fault->primaryKey => $fault_id));
            $fault = $this->Fault->find('first', $options);

            $this->loadModel('User');
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $fault['User']['id']));
            $counsilor = $this->User->find('first', $options);

            $subject = "Fault completed";
            //Send the notification to the logged in user.
            $Email->from(array('no-reply@lejweleputswa.com' => 'Matjhabeng Local Municipality Document Management System Faults'))
                ->template('completed', 'default')
                ->emailFormat('html')
                ->viewVars(array('fault' => $fault))
                ->to($counsilor['User']['email']);
                //->bcc('maffins@gmail.com')
                //->subject($subject)
                //->send();

            return $this->redirect(array('action' => 'index', 'controller' => 'Faults', $fault_id));
        }

        $this->set('fault_id', $fault_id);
    }

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
            $this->request->data['Fault']['user_id'] = $this->Auth->user('id');
			$this->Fault->create();
			if ($this->Fault->save($this->request->data)) {

			    $fault_id = $this->Fault->getLastInsertId();
                $options = array('conditions' => array('Fault.' . $this->Fault->primaryKey => $fault_id));
                $fault = $this->Fault->find('first', $options);

                //Save the uploaded files
                $myUploads = $this->request->data['Fault']['document_name'];
                unset($this->request->data['Fault']['document_name']);
                $this->loadModel('FaultsDocument');
                $faultDetails = [];
//var_dump($myUploads);die;
                foreach( $myUploads as $upload) {

                    $this->FaultsDocument->create();

                    if (!empty($upload['name'])) {

                        $file = $upload;//put the data into a var for easy use
                        $original_name = $file['name'];
                        $file['name'] = preg_replace('/\s+/', '_', $file['name']);
                        move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'counsilor_faults' . DS . $file['name']);
                        //prepare the filename for database entry
                        $faultDetails['FaultsDocument']['document_name'] = $file['name'];
                        $faultDetails['FaultsDocument']['original_name'] = $original_name;

                    } else {
                        $faultDetails['FaultsDocument']['original_name'] = 'No Document';
                    }
                    $faultDetails['FaultsDocument']['fault_id'] = $fault_id;

                    if ($this->FaultsDocument->save($faultDetails)) {

                        $this->Flash->success(__('Documents Uploaded successfuly.'));

                    } else {
                        die('Cannot save the fault documents');
                    }

                }

                //Compose and email and send to the speakers office
                $Email = new CakeEmail();

                $this->loadModel('User');
                $users = $this->User->find('all', array('conditions'=>array('User.user_type_id' => 16)));

                //Get reporting counsilor
                $options = array('conditions' => array('User.' . $this->User->primaryKey => $this->Auth->user('id')));
                $counsilor = $this->User->find('first', $options);

                foreach ($users as $user) {

                    $subject = "Counsilor ".$user['User']['fname'] . ' ' . $user['User']['sname']." has sent a fault";
                    //Send the notification to the logged in user.
                    $Email->from(array('no-reply@lejweleputswa.com' => 'Matjhabeng Local Municipality Document Management System Faults'))
                        ->template('faultreported', 'default')
                        ->emailFormat('html')
                        ->viewVars(array('fault' => $fault, 'name' => $counsilor['User']['fname'] . ' ' . $counsilor['User']['sname']))
                        ->to($user['User']['email'])
                        ->bcc('maffins@gmail.com')
                        ->subject($subject)
                        ->send();
                }

				$this->Session->setFlash(__('The fault has been sent.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fault could not be sent. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$users = $this->Fault->User->find('list');
		$this->set(compact('users'));
	}


    public function sendFile($id) {
        $this->loadModel('FaultsDocument');
        $options = array('conditions' => array('FaultsDocument.' . $this->FaultsDocument->primaryKey => $id));
        $file = $this->FaultsDocument->find('first', $options);
        $path = '/webroot/uploads/counsilor_faults/'.$file['FaultsDocument']['document_name'];
        // echo $path;die;
        $this->response->file($path);
        // Return response object to prevent controller from trying to render
        // a view
        return $this->response;
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Fault->exists($id)) {
			throw new NotFoundException(__('Invalid fault'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Fault->save($this->request->data)) {
				$this->Session->setFlash(__('The fault has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fault could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Fault.' . $this->Fault->primaryKey => $id));
			$this->request->data = $this->Fault->find('first', $options);
		}
		$users = $this->Fault->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Fault->id = $id;
		if (!$this->Fault->exists()) {
			throw new NotFoundException(__('Invalid fault'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Fault->delete()) {
			$this->Session->setFlash(__('The fault has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The fault could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
