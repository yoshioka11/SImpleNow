<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController {

  public $components = array('Paginator','Session', 'Auth');

  public $uses = array(
    'Topic',
    'User');


  public function beforeFilter()
  {
    parent::beforeFilter();

    $this->Auth->allow('register', 'login');
$this->Auth->allow('view');
$this->set('user', $this->Auth->user());
  }

  public function index(){
    $this->set('user', $this->Auth->user());
  }

  public function register(){

    if($this->request->is('post')) {
      if ($this->User->save($this->request->data)) {
        $this->Auth->login();
        $this->redirect('/');
      }
    }
  }

  public function login(){
    if($this->request->is('post')) {
      if($this->Auth->login())
        return $this->redirect('/');
      else
        $this->Session->setFlash('ログインに失敗しました');
    }
  }

  public function logout(){
    $this->Auth->logout();
    $this->redirect('/');
  }

  public function view($id = null) {
    if (!$this->User->exists($id)) {
      throw new NotFoundException(__('Invalid category'));
    }
    $user = $this->Auth->user();
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $id),
      );

    


    $this->set('topics',($this->Topic->find('all', array(
      'conditions' => array('Topic.user_id' => $id),
      'order' => array('Topic.created' => 'DESC')))));
    /*var_dump($this->User->find('all'));
    $this->set('user', $this->Topic->find('all', array(
      'conditions' => array('Topic.user_id' => $id),
      'order' => array('Topic.created' => 'DESC'),
      )));*/
  }


}

?>