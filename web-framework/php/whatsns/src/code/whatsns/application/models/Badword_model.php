<?php


class Badword_model  extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}


    function get_list($start=0,$limit=20){
        $wordlist = array();
        $query = $this->db->query("SELECT * FROM ".$this->db->dbprefix."badword  ORDER BY `id` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $word ) {
        	$word['find']=str_replace("\"","&#34;",$word['find']);
        	$word['find'] = str_replace( "'", "&#39;",$word['find']);
        	$word['replacement']=str_replace("\"","&#34;",$word['replacement']);
        	$word['replacement'] = str_replace( "'", "&#39;",$word['replacement']);
            $wordlist[] = $word;
        }
        return $wordlist;
    }
    function add($wids,$finds,$replacements,$admin){
        $wsize = count($wids);
        for($i=0;$i<$wsize;$i++){
            if($wids[$i]){
            	$this->db->set(array('find'=>$finds[$i],'replacement'=>$replacements[$i]))->where(array('id'=>$wids[$i]))->update('badword');
            }else{
            	if($finds[$i] ){
            		$this->db->insert('badword',array('admin'=>$admin,'find'=>$finds[$i],'replacement'=>$replacements[$i]));
            	}
            }
        }
    }

    function multiadd($lines,$admin){
        $sql = "INSERT INTO `".$this->db->dbprefix."badword`(`admin` ,`find` , `replacement`) VALUES ";
        $datas=array();
        foreach ($lines as $line){
            $line=str_replace(array("\r\n", "\n", "\r"), '', $line);
            if(empty($line))continue;
            @list($find,$replacement)=explode('=' , $line);
            $find=addslashes($find);
            $replacement=addslashes($replacement);
            $admin=addslashes($admin);

            $data=array(
            		'admin'=>$admin,
            		'find'=>$find,
            		'replacement'=>$replacement
            );
            array_push($datas, $data);
        }
        $this->db->insert_batch('badword', $datas); 
       
    }

    function remove_by_id($ids){
    	$this->db->where_in('id',explode(',', $ids))->delete('badword');
    }

}
?>