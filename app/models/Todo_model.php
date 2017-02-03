<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @category Model
 * @author Florian Dahlitz
 *
 * handles todo-based data
 */
class Todo_model extends MY_Model
{
    /**
     * default table
     */
    protected $table = 'todos';
    
    /**
     * relation table
     */
    protected $table_rel = 'todos_users';
    
    /**
     * validation rules
     */
    protected $validation_rules = [
        [
            'field' => 'title',
            'label' => 'Titel',
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Bitte geben Sie einen Titel ein',
                'min_length' => 'Der Titel muss mindestens 4 Zeichen umfassen'
            ]
        ],
        [
            'field' => 'content',
            'label' => 'Inhalt',
            'rules' => 'required|min_length[10]',
            'errors' => [
                'required' => 'Bitte geben Sie einen Text/Inhalt ein',
                'min_length' => 'Der Text/Inhalt muss mindestens 10 Zeichen umfassen'
            ]
        ]
    ];
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function add_rel($user_ids, $dash_link = 0)  // $user_ids has to be an array
    {
        $data = [];
        $tmp = [];
        $this->db->order_by('date', 'DESC');
        $this->db->order_by('id', 'DESC');
        $todo_id = $this->db->get($this->table)->row()->id;
        
        foreach($user_ids as $user_id)
        {
            $tmp['user_id'] = $user_id;
            $tmp['todo_id'] = $todo_id;
            $tmp['dash_link'] = $dash_link;
            $data[] = $tmp;
        }
        
        return $this->db->insert_batch($this->table_rel, $data);
    }
}