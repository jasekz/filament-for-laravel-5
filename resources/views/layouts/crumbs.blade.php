<?php 

if(isset($crumbs)) {
    $str = '';
    $arr = explode('>>', $crumbs); 
    $count = 0;
    foreach($arr as $crumb) {
        $count++;
        
        if( $str ) {
            $str .= '<i class="fa fa-angle-double-right" style="padding:0 5px 0 5px;" ></i>';
        }
        
        if($count == count($arr)) {
            $str .= '<strong>' . $crumb . '</strong>';
        } else {
            $str .= $crumb;
        }
    }
} else {
    $str = 'Home';
}
?>

{!! $str !!}
