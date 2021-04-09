<?php
class M_api extends CI_Model {
        

    function insert_presensi($data){
		$this->db->insert('log', $data);
       return TRUE;
	}


	function get_absensi($ket,$today,$tomorrow){
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->where("keterangan", $ket);
        $this->db->where("absensi_masuk >=", $today);
        $this->db->where("absensi_masuk <", $tomorrow);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    function update_absensi($id_absensi, $data){
        $this->db->where('id_absensi', $id_absensi);
        $this->db->update('absensi', $data);

        return TRUE;
    }

    function getFIDdelete(){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("del_face_id", 1);
        $this->db->order_by('face_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function getFIDdelete_by_face_id($face_id){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("face_id", $face_id);
        $this->db->order_by('face_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function del_face_by_id_face_table($id){
        $this->db->where('id_face_table', $id);
        $this->db->delete('face');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }


    function del_log_by_id_face_table($id_face_table){
        $this->db->where('id_face_table', $id_face_table);
        $this->db->delete('log');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function getFID(){
        $this->db->select('*');
        $this->db->from('face');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }



    function checkface($face_id){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where("face_id", $face_id);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function waktuoperasional(){
        $this->db->select('*');
        $this->db->from('waktu_operasional');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function get_absensi_by_employee_today($id_face_table, $today){
        $this->db->select('*');
        $this->db->from('log');
        $this->db->where("id_face_table", $id_face_table);
        $this->db->where("log_masuk >=", $today);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

}

?>