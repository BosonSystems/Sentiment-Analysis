@extends('layout.index')

@section('content')
<table class="table table-striped table-hover">
    <tr><th>Date#</th>
        <th>Open</th>
        <th>High</th>
        <th>Close</th>
        <th>Open %</th>
        <th>Close %</th>
        <th>Total Qty</th>
        <th>Total Trd</th>
        <th>Total Trades</th>
    </tr>
        <?php
foreach($stock as $row) {
    //print_r($row);
    echo "<tr>
        <td>$row->day</td>
        <td>".round($row->open,2)."</td>
        <td>".round($row->high,2)."</td>
        <td>".round($row->close,2)."</td>
        <td>".round($row->openp,2)."</td>
        <td>".round($row->pvalue,2)."</td>
        <td>$row->tottrdqty</td>
        <td>$row->tottrdval</td>
        <td>$row->totaltrades</td>
        </tr>";
}

        ?>
<tr class="info">
    <td colspan="3"><h4>{{$row->isin}}</h4></td>
    <td colspan="3"><h4><a href='http://www.moneycontrol.com/stocks/cptmarket/compsearchnew.php?search_data=&cid=&mbsearch_str=&topsearch_type=1&search_str={{$row->isin}}' target='_blank'>{{$row->symbol}}</a></h4></td>
    <td colspan="3"><h4>{{$row->series}}</h4></td>
</tr>
</table>
@stop
