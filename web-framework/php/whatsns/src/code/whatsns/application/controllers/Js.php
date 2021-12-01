<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Js extends CI_Controller {

     function __construct() {
       parent::__construct();
        $this->load->model('question_model');
        $this->load->model('datacall_model');
    }

    function view() {
        $id = intval($this->uri->segment ( 3 ));
        $datacall = $this->datacall_model->get($id);
        !$datacall && exit(" document.write('非法调用!') ");
        $expressionarr = unserialize($datacall['expression']);
        $jscache = $this->cache->read('js_' . $id, $expressionarr['cachelife']);
        if (!$jscache) {
            $tpl = stripslashes(base64_decode($expressionarr['tpl']));
            $cid = 0;
            $cfield = '';
            if ($expressionarr['category']) {
                $cids = explode(":", substr($expressionarr['category'], 0, -1));
                foreach ($cids as $c) {
                    $c && $cid = $c;
                }
            }
            $cid && $cfield = 'cid' . $this->category[$cid]['grade'];

            $questionlist = $this->question_model->list_by_cfield_cvalue_status($cfield, $cid, $expressionarr['status'], $expressionarr['start'], $expressionarr['limit']);
            $jscache = '';
            foreach ($questionlist as $question) {
                $replaces = array();
                foreach ($question as $qkey => $qval) {
                    $replaces["[$qkey]"] = $qval;
                }
                $replaces['[title]'] = cutstr(strip_tags($question['title']), $expressionarr['maxbyte']);
                $replaces['[qid]'] = $question['id'];
                $replaces['[time]'] = tdate($question['time']);
                $replaces['[category_name]'] = $this->category[$cid]['name'];
                $replaces['[cid]'] = $cid;
                $replaces['[author]'] = $question['author'];
                $replaces['[authorid]'] = $question['authorid'];
                $replaces['[answers]'] = $question['answers'];
                $replaces['[views]'] = $question['views'];
                $jscache.=$this->replacesitevar($tpl, $replaces);
            }
            $this->cache->write('js_' . $id, $jscache);
        }
       echo "document.write('$jscache')";
    }

    function replacesitevar($string, $replaces = array()) {
        return str_replace(array_keys($replaces), array_values($replaces), $string);
    }

}

?>