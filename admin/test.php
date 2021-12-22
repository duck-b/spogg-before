<?php
$filename = 'test.xlsx';
header("Content-type: application/vnd.ms-excel" );
header("Content-Disposition: attachment; filename=".$filename);
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>
<table>
    <tr>
    <td>하나</td>
    <td>둘</td>
    </tr>
    <?php for($i=0; $i<10; $i++){ ?>
    <tr>
    <td><?php echo $i ?></td>
    <td><?php echo $i+1 ?></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>