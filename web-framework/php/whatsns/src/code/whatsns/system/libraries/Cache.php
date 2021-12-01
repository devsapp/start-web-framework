<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CI_Cache {

	protected $CI;
    var $cachefile;

    function __construct() {
       $this->CI =& get_instance();
    }

    function getfile($cachename) {
        $this->cachefile = FCPATH . '/data/cache/' . $cachename . '.php';
    }

    function isvalid($cachename, $cachetime) {
        if (0 == $cachetime)
            return true;
        $this->getfile($cachename);
        if (!is_readable($this->cachefile) || $cachetime < 0) {
            return false;
        }
        clearstatcache();
        return (time() - filemtime($this->cachefile)) < $cachetime;
    }

    function read($cachename, $cachetime=0) {
        $this->getfile($cachename);
        if ($this->isvalid($cachename, $cachetime)) {
            return @include $this->cachefile;
        }
        return false;
    }

    function write($cachename, $arraydata) {
        $this->getfile($cachename);
        if (!is_array($arraydata))
            return false;
        $strdata = "<?php\nreturn " . var_export($arraydata, true) . ";\n?>";
        $bytes = writetofile($this->cachefile, $strdata);
        return $bytes;
    }

    function remove($cachename) {
        $this->getfile($cachename);
        if (file_exists($this->cachefile)) {
            unlink($this->cachefile);
        }
    }

    function load($cachename, $id='id', $orderby='') {
        $arraydata = $this->read($cachename);
        if (!$arraydata) {
            //$sql = 'SELECT * FROM ' . DB_TABLEPRE . $cachename;
           // $orderby && $sql.=" ORDER BY $orderby ASC";
            $query = $this->CI->db->get_where($cachename);
            foreach ($query->result_array() as $item){
               if (isset($item['k'])) {
                    $arraydata[$item['k']] = $item['v'];
                } else {
                    $arraydata[$item[$id]] = $item;
                }
            }

            $this->write($cachename, $arraydata);
        }
        return $arraydata;
    }

}

?>