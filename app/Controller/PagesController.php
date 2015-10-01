<?php

App::uses('AppController', 'Controller');
class PagesController extends AppController {

	public $components = array('Session', 'Auth');
	public $uses = array(
		'Category',
		'Comment',
		'Topic',
		'User'
	);
	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'detail');
        $this->set('user', $this->Auth->user());
    }

	public function index() {

        $user = $this->Auth->user();    
        //データを昇順で表示させている（DESC）
		$topics = $this->Topic->find('all',array(
            'order' => array('Topic.created'=> 'DESC'),
            ));
        
        
$this->set('topics', $topics);
        if ($this->request->is('post')) {
            $this->Topic->create();
            $this->request->data['Topic']['user_id'] = $user['id'];
            $this->set('data', $this->request->data);
            if ($this->Topic->save($this->request->data)) {
                $this->Session->setFlash('保存に成功しました');
                return $this->redirect('/');
            } else {
                $this->Session->setFlash('保存に失敗しました');
            }
        }


// 		$this->set('topics', $topics);
//         $users = $this->User->find('all');
//         $this->set('users', $users);
//         if($this->request->is('post')){
//             $this->Topic->create();
//             $this->request->data['Topic']['user_id'] = $user['id'];
//             $this->Topic->save($this->request->data); 
//             $this->redirect('/');
                
// }
        $categories = $this->Category->find('list');
        $this->set('categories', $categories);
        


	}

    public function detail() {
        // パラメーターを取得
        $id = $this->request->params['id'];

        if (!$this->Topic->exists($id)) {
            throw new NotFoundException('Invalid topic');
        }

        $options = array( 
            'conditions' => array(
                'Topic.id' => $id
            )
        );

        $this->set('topic', $this->Topic->find('first', $options));

        $this->request->data['Comment']['topic_id'] = $id;
        if($this->request->is('post')){
            $this->Topic->Comment->create();
            if($this->Topic->Comment->save($this->request->data)){
                $this->Session->setFlash('complete');
                $this->redirect($this->referer());
            }
        }
        
        $topic_comments = $this->Topic->Comment->find('all', array(
            'fields' => array('Comment.comment', 'Comment.title', 'Comment.comment_name'),
            'conditions' => array('Comment.topic_id' => $id),
            
        ));
        $user = $this->Auth->user();
        $this->set(compact('topic_comments', 'user'));
        
    }
}
