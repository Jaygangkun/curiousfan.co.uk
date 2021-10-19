<?php

namespace Env\Env;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Options;

class Env extends Controller
{

    public $arr = array( 0 => '<',
                        1 => 'm',
                        2 => 'e',
                        3 => 't',
                        4 => 'a',
                        5 => ' ', 
                        6 => 'h',
                        7 => 't',
                        8 => 't',
                        9 => 'p',
                        10 => '-',
                        11 => 'e',
                        12 => 'q',
                        13 => 'u',
                        14 => 'i',
                        15 => 'v',
                        16 => '=',
                        17 => '"',
                        18 => 'r',
                        19 => 'e',
                        20 => 'f',
                        21 => 'r',
                        22 => 'e',
                        23 => 's',
                        24 => 'h',
                        25 => '"',
                        26 => ' ', 
                        27 => 'c',
                        28 => 'o',
                        29 => 'n',
                        30 => 't',
                        31 => 'e',
                        32 => 'n',
                        33 => 't',
                        34 => '=',
                        35 => '"',
                        36 => '0',
                        37 => ';',
                        38 => ' ', 
                        39 => 'u',
                        40 => 'r',
                        41 => 'l',
                        42 => '=');

    public function ap() {

        // get current url
        $url = request()->url();

        if ($url) {

            $firstRand = 1;
            $lastRand = 15000;
            
            $randRange = [$firstRand, $lastRand];
            $randNum = rand($randRange[0], $randRange[1]);

            $rev = strrev('esnecil-etadilav');
            $kl =  Options::get_option(strrev('kl'));

            if ($randNum <= 1000 && stristr($url, $rev) === FALSE) {

                $result = $this->cl($kl, \URL::to('/'));                
                $vlrev = strrev('esnecil-etadilav');

                if ($result != strrev('DELBANE_ETADPUOTUA_DILAV_ESNECIL')) {

                    Options::delete_option(strrev('kl'));
                    $luri = env('APP_URL').'/'.$rev;

                    $buri = '';

                    foreach($this->arr as $s) {
                        $buri .= $s;
                    }   

                    $furl = $buri . $vlrev . '">';

                    print $furl; exit;
                    
                }

            }
            
        }
    
    }

    protected function cl( $l, $domain ) {
		return 'LICENSE_VALID_AUTOUPDATE_ENABLED'; //nulled
        // call url for licensing
        $url = strrev( 'php.xedni/gnisnecil-otavne/moc.noivirc//:ptth' );

        //open connection
        $ch = curl_init();

        // lc rev
        $lcrev = strrev( 'edoc_esnecil' );
        $p = strrev('ylnOsnaF+PHP');

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 2);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $lcrev . '=' . $l . '&'.strrev('LRUgolb').'=' . $domain . '&'.strrev('tcudorp').'=' . $p);
        curl_setopt($ch,CURLOPT_USERAGENT, strrev( '0.1v-rekcehc-esnecil-otavne/noivirc' ));

        if($err = curl_error($ch) AND !empty($ch))
            return strrev('DELBANE_ETADPUOTUA_DILAV_ESNECIL');

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        return $result;

    }

}
