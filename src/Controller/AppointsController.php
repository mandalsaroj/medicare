<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Appoints Controller
 *
 * @property \App\Model\Table\AppointsTable $Appoints
 */
class AppointsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Patients', 'Doctors']
        ];
        $appoints = $this->paginate($this->Appoints);

        $this->set(compact('appoints'));
        $this->set('_serialize', ['appoints']);
    }

    /**
     * View method
     *
     * @param string|null $id Appoint id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $appoint = $this->Appoints->get($id, [
            'contain' => ['Patients', 'Doctors']
        ]);

        $this->set('appoint', $appoint);
        $this->set('_serialize', ['appoint']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $appoint = $this->Appoints->newEntity();
        if ($this->request->is('post')) {
            $appoint = $this->Appoints->patchEntity($appoint, $this->request->data);
            if ($this->Appoints->save($appoint)) {
                $this->Flash->success(__('The appoint has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The appoint could not be saved. Please, try again.'));
            }
        }
        $patients = $this->Appoints->Patients->find('list', ['limit' => 200]);
        $doctors = $this->Appoints->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('appoint', 'patients', 'doctors'));
        $this->set('_serialize', ['appoint']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Appoint id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $appoint = $this->Appoints->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $appoint = $this->Appoints->patchEntity($appoint, $this->request->data);
            if ($this->Appoints->save($appoint)) {
                $this->Flash->success(__('The appoint has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The appoint could not be saved. Please, try again.'));
            }
        }
        $patients = $this->Appoints->Patients->find('list', ['limit' => 200]);
        $doctors = $this->Appoints->Doctors->find('list', ['limit' => 200]);
        $this->set(compact('appoint', 'patients', 'doctors'));
        $this->set('_serialize', ['appoint']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Appoint id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $appoint = $this->Appoints->get($id);
        if ($this->Appoints->delete($appoint)) {
            $this->Flash->success(__('The appoint has been deleted.'));
        } else {
            $this->Flash->error(__('The appoint could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
