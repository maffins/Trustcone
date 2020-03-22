<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * CousilorReports Controller
 *
 * @property CousilorReport $CousilorReport
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class CousilorReportsController extends AppController {

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
        if ($this->Auth->user()['user_type_id'] == 16) {
            $this->CousilorReport->recursive = 0;
            $this->set('cousilorReports', $this->Paginator->paginate());
            $this->set('user_type_id', $this->Auth->user()['user_type_id']);
        }else {
            $this->paginate = [
                'conditions' => [
                    'CousilorReport.user_id' => $this->Auth->user('id'),
                ]
            ];
            $this->set('cousilorReports', $this->paginate($this->CousilorReport));
            $this->set('user_type_id', $this->Auth->user()['user_type_id']);
        }
        //$this->set('_serialize', ['cousilorReports']);
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CousilorReport->exists($id)) {
			throw new NotFoundException(__('Invalid cousilor report'));
		}
		$options = array('conditions' => array('CousilorReport.' . $this->CousilorReport->primaryKey => $id));
		$this->set('cousilorReport', $this->CousilorReport->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
            $myUploads = $this->request->data['CousilorReport']['original_name'];
            unset($this->request->data['CousilorReport']['original_name']);

            $allfiles[] = '';

            foreach ($myUploads as $upload) {
                if (!empty($upload['name'])) {
                    $file = $upload;//put the data into a var for easy use
                    $original_name = $file['name'];
                    $file['downloadname'] = preg_replace('/\s+/', '_', $file['name']);
                    move_uploaded_file($file['tmp_name'], WWW_ROOT . 'uploads' . DS . 'counsilor_reports' . DS . $file['name']);
                    //prepare the filename for database entry
                    $this->request->data['CousilorReport']['downloadname'] = $file['name'];
                    $this->request->data['CousilorReport']['original_name'] = $original_name;
                    $this->request->data['CousilorReport']['user_id'] = $this->Auth->user('id');

                    //Build the array that holds the files
                    $allfiles[$original_name] = WWW_ROOT . 'uploads' . DS . 'counsilor_reports' . DS . $file['name'];
                    //print_r($this->request->data);die;
                    $this->CousilorReport->create();
                    if ($this->CousilorReport->save($this->request->data)) {
                        $this->Session->setFlash(__('The report has been saved and sent.'), 'default', array('class' => 'alert alert-success'));

                    } else {
                        die('There was a problem with the uploading');
                        $this->Session->setFlash(__('The cousilor report could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
                    }
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

                $subject = "Counsilor ".$counsilor['User']['fname'] . ' ' . $counsilor['User']['sname']." has sent reports";
                //Send the notification to the logged in user.
                $Email->from(array('no-reply@lejweleputswa.com' => 'Matjhabeng Local Municipality Document Management System Faults'))
                    ->template('sendcounsilorreport', 'default')
                    ->emailFormat('html')
                    ->viewVars(array('name' => $counsilor['User']['fname'] . ' ' . $counsilor['User']['sname']))
                    ->attachments($allfiles)
                    ->to($user['User']['email'])
                    ->bcc('maffins@gmail.com')
                    ->subject($subject)
                    ->send();
            }
            return $this->redirect(array('action' => 'index'));
        }
		$users = $this->CousilorReport->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CousilorReport->exists($id)) {
			throw new NotFoundException(__('Invalid cousilor report'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CousilorReport->save($this->request->data)) {
				$this->Session->setFlash(__('The cousilor report has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cousilor report could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('CousilorReport.' . $this->CousilorReport->primaryKey => $id));
			$this->request->data = $this->CousilorReport->find('first', $options);
		}
		$users = $this->CousilorReport->User->find('list');
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
		$this->CousilorReport->id = $id;
		if (!$this->CousilorReport->exists()) {
			throw new NotFoundException(__('Invalid cousilor report'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CousilorReport->delete()) {
			$this->Session->setFlash(__('The cousilor report has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The cousilor report could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}


    public function sendFile($id) {
        $this->loadModel('CousilorReport');
        $options = array('conditions' => array('CousilorReport.' . $this->CousilorReport->primaryKey => $id));
        $file = $this->FaultsDocument->find('first', $options);
        $path = '/webroot/uploads/counsilor_reports/'.$file['CousilorReport']['downloadname'];
        // echo $path;die;
        $this->response->file($path);
        // Return response object to prevent controller from trying to render
        // a view
        return $this->response;
    }
}
