<?php
$page = intval($paging['page']);
$rows_num = intval($paging['rows_num']);
$rows_per_page = intval($paging['rows_per_page']);
$f_num = ($page * $rows_per_page) + 1;
$m_num = ($page + 1) * $rows_per_page;
if ($m_num > $rows_num) $m_num = $rows_num;

$older_page = $page - 1;
$newer_page = $page + 1;

$max_page = ceil($rows_num / $rows_per_page);

$get_older_data_func = '';
$get_newer_data_func = '';

$older_css = 'adS';
if ($older_page > -1) {
    $older_css = 'aaT';
    $get_older_data_func = 'onclick="jQuery.UbizOIWidget.w_get_older_data(' . $older_page . ')"';
}

$newer_css = 'adS';
if ($newer_page < $max_page) {
    $newer_css = 'aaT';
    $get_newer_data_func = 'onclick="jQuery.UbizOIWidget.w_get_newer_data(' . $newer_page . ')"';
}
?>
<div id="paging-label" class="amH" style="user-select: none">
    <span class="Dj">
        <span>
            <span class="ts">{{$f_num}}</span>
            –
            <span class="ts">{{$m_num}}</span>
        </span>
        /
        <span class="ts">{{$rows_num}}</span></span>
</div>
<div id="paging-older" class="amD utooltip" title="Cũ hơn"  <?php echo $get_older_data_func;?>>
    <span class="amF">&nbsp;</span>
    <img class="amI {{$older_css}}" src="http://ubiz.local/images/cleardot.gif" alt="">
</div>
<div id="paging-newer" class="amD utooltip" title="Mới hơn" <?php echo $get_newer_data_func;?>>
    <span class="amF">&nbsp;</span>
    <img class="amJ {{$newer_css}}" src="http://ubiz.local/images/cleardot.gif" alt="">
</div>
