<?php
    class Crud extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //[INSERT]
    public function insert_data(){
        $fname=$this->input->post('fname');             //fetch data sent by form over POST using specific input name
        $lname=$this->input->post('lname');
        $age=$this->input->post('age');
        $skill=$this->input->post('skill');
        $insert_data = array(                           //array of all data to be inserted into db
            'first_name'=>$fname,
            'last_name'=>$lname,
            'age' => $age,
            'skill' => $skill,
            );

                //on successful insert of data
                 if($this->db->insert('demo', $insert_data)){       //load array to database
                                                                    //show success message
                         echo "Congratulations ".$insert_data['first_name']." your data was successfully inserted !!<br><br>";
                         echo "<a href='".base_url()."main/read'>"."Main Page </a>";
                    }else{
                        echo "Sorry ".$insert_data['first_name']." your data was not inserted !!<br><br>";
                        echo "<a href='".base_url()."'>"."Main Page </a>";
                    }
            }

            //fetch/READ data from database [SELECT]
        public function read_data(){
                $query = $this->db->query('SELECT * FROM demo ORDER BY id DESC');       //show the latest inserted data first
                return $query->result_array();
            }

            //Edit data from database
        public function edit_data(){
                $id=$_REQUEST['id'];
                $query = $this->db->get_where('demo', array('id' => $id));          //get the row specified by id from the table demo
                return $query->result_array();                                      //return the query result
            }
            //UPDATE data
        public function update_data($id){
                    $fname=$this->input->post('fname');
                    $lname=$this->input->post('lname');
                    $age=$this->input->post('age');
                    $skill=$this->input->post('skill');

                    $data = array(
                        'first_name' => $fname,
                        'last_name' => $lname,
                        'age' => $age,
                        'skill' => $skill,
                        );
                    $this->db->where('id', $id);

                    if($this->db->update('demo', $data)){                       //check if update was successfull
                        return true;
                    }else{
                        return false;
                    }
                }


            //DELETE data
        public function delete_data($id){
                if($this->db->delete('demo',array('id'=>$id))){
                    return true;
                }else{
                    return false;
                }

            }

            //check if first_name && last_name is unique
        public function distinct_data($allData){
                $fname=$this->input->post('fname');
                $lname=$this->input->post('lname');
                foreach ($allData as $info) {
                    if($info['first_name']==$fname && $info['last_name']==$lname){
                        return false;
                    }
                }
                return true;
            }

            //method for searching
        public function search_id($text){
                $this->db->select('id');                        //SELECT id
                $this->db->from('demo');                        //FROM demo
                $this->db->like('first_name',$text);            //first_name LIKE $text
                $this->db->or_like('last_name',$text);          //OR last_name LIKE $text
                $this->db->or_like('age',$text);                //OR age LIKE $text
                $this->db->or_like('skill',$text);              //OR skill LIKE $text
                $query=$this->db->get();

                return  $query->result_array();         //return as a asscoc array of id
            }

         // method to serach a place ..Is it stored or not
        public function search_location($location){
            $this->db->
        }

            //raed the specific data as passed by parameter
        public function read_specific_data($result){
                //loop over nested arrays and find all data of given IDs
                foreach ($result as $key => $value) {
                    foreach ($value as $key2 => $value_in) {
                        //echo $value_in."<br>";
                        $result_data[$key]=$this->read_all($value_in);
                }
            }
            return $result_data;
        }

        public function read_all($id){
                $query = $this->db->get_where('demo', array('id' => $id));
                return $query->result_array();
        }

        public function search_filterId($text,$filter){
                $this->db->select('id');
                $this->db->from('demo');


                //search by filter [by column]
                switch ($filter) {
                    case 'username':
                        $this->db->like('first_name',$text);
                        $this->db->or_like('last_name',$text);
                        break;
                    case 'age':
                        $this->db->like('age',$text);
                        break;
                    case 'skill':
                        $this->db->like('skill',$text);
                        break;
                }

                $query=$this->db->get();                //get all data required
                return $query->result_array();          //return as a asscoc array of id
        }
    }
 ?>
