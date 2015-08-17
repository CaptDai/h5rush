<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- 输出页面标题 -->
    <title><?php echo $pageInfo['title']; ?></title>

    <!-- link css文件 -->
    <link rel="stylesheet" href="./assets/css/bs3/dpl-min.css"/>
    <link rel="stylesheet" href="./assets/css/bs3/bui-min.css"/>
    <link rel="stylesheet" href="./css/main.css"/>
</head>
<body>

<?php $this->render($view,$data); ?>


<!-- link javascript -->
<script type="text/javascript" src="./src/jquery-1.8.1.min.js"></script>
<script type="text/javascript" src="./build/seed-min.js"></script>

<!-- link 页面中独有的js文件 （使用数组传值） -->
<?php if( isset($pageInfo['jsFile']) && is_array($pageInfo['jsFile']) ) foreach ($pageInfo['jsFile'] as $value) { ?>
        <script type="text/javascript" src="./js/<?php echo $value; ?>.js"></script>
<?php } ?>


</body>
</html>