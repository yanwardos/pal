<?php
class M_admin extends CI_Model {

    

    function get_face_all(){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->order_by('face_id', 'desc');
        //$this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }


    function get_face_id($id_devices){
        $this->db->select('*');
        $this->db->from('face');
        $this->db->where('id_devices',$id_devices);
        $this->db->order_by('face_id', 'desc');
        //$this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    function add_face_id($data){
        $this->db->insert('face', $data);
        return TRUE;
    }

    function del_face_id($id,$data){
        $this->db->where('id_face_table', $id);
        $this->db->update('face', $data);

        return TRUE;
    }

    function get_face_byid($id){
        $query = $this->db->where('id_face_table',$id);
        $q = $this->db->get('face');
        $data = $q->result();
        
        return $data;
    }

    function updateFace($id,$data){
        $this->db->where('id_face_table', $id);
        $this->db->update('face', $data);

        return TRUE;
    }


    function del_histori_by_iddev($id_devices){
        $this->db->where('id_devices', $id_devices);
        $this->db->delete('histori');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function get_log($today,$tomorrow){
        $this->db->select('*');
        $this->db->from('log');
        $this->db->join('face','log.id_face_table=face.id_face_table','inner');
        $this->db->where("log_masuk >=", $today);
        $this->db->where("log_masuk <", $tomorrow);
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

    function updateWaktuOperasional($id,$data){
        $this->db->where('id_waktu_operasional', $id);
        $this->db->update('waktu_operasional', $data);

        return TRUE;
    }
}

?>