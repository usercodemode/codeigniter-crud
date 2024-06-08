<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    private $db;
    
    public function __construct()
    {
        $this->db = db_connect();
    }
    
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $users = $this->db->table('users')->get()->getResult();
        
        $data['users'] = $users;
        
        return view('read_users',$data);

    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        return view('new_user');
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age')
        ];
        
        $result = $this->db->table('users')->insert($data);
        
        $status = ($result) ? 'Record has been inserted :)': 'Record has not been inserted :(';
        
        return redirect()->to(base_url('users'))->with('status', $status);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        $user = $this->db->table('users')->getWhere(['id'=>$id],1)->getRow();
        $data['user'] = $user;
        
        return view('update_form',$data);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $user = new User();
        //$user = $this->db->table('users');
        
        $data = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age'),
        ];
        $result = $user->update($id, $data);
        $status = ($result) ? 'Records has been updated :)': 'Records has not been updated :(';
        
        return redirect()->to(base_url('users'))->with('status', $status);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $result = $this->db->table('users')->where('id', $id)->delete();
        
        $status = ($this->db->affectedRows()) ? 'Records has been deleted :)': 'Records has not been deleted :(';
        
        return redirect()->to(base_url('users'))->with('status', $status);
    }
}
