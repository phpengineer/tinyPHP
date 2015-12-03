<?php
/**
 * @author  renhai
 * @version  1.0
 */
class TestModel extends Model {
		private  $table = 'test';
	
        public function getTestData() {
             $result = $this->db->select($this->table)->getAssoc();
             return $result;
        }
        
        public function testResult() {
             $this->db->show_databases();
        }
}


