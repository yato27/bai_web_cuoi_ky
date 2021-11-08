<?php if (!defined('IN_SITE')) die('The request not found'); ?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Quản lý học sinh</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="<?php #base_url('admin/?m=widgets&a=style.css')?>"> -->
        <!-- <link rel="stylesheet" href="<?php #echo (base_url('admin/widgets/style.css'))?>"> -->
        
        <link rel="stylesheet" href="<?php echo (base_url('assets/css/style.css'))?>">

        <style type="text/css">
            
            .main {
                /* background: linear-gradient(to right top, #65dfc9, #6cdbeb); */
                background-color:    rgb(19, 17, 17); 
                opacity: 1;
                
            }

            #header li{
                float: left;
                padding: 5px 10px;
                /* border: solid 1px blue; */
                background: rgb(19, 17, 17);
                margin-right: 10px;
                list-style: none;
                border-radius: 5px;
                font-size: 18px;
                font-weight: 600px;
            }
            #header{
                overflow: hidden;
            }
            #header li a{
                color: #fff;
                text-decoration: none;
            }
            /* #header div{
                float: right;
                width: 250px;
                line-height: 50px;
                padding-right: 20px;
            } */
            /* #header ul{
                margin: 20px auto;
                width: 700px;
                float: left;
            } */
            body{
                background: #acacac;
                margin: 0px;
                padding: 0px;
            }
            #container{
                /* max-height: 750px !important; */
                width: 95%;
                margin: 2% auto;
                overflow: hidden;
                
                background-color: white;
                border-radius: 2rem;
                }
            #content{
                min-height: 350px;
                padding: 10px 30px;
            }
            .button{
                display: inline-block;
                padding: 5px 10px;
                background: rgb(19, 17, 17);
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
            }
            .pagination a{
                display: inline-block;
                padding: 3px 8px;
                background: rgb(19, 17, 17);
                color: #fff;
                text-decoration: none;
                margin-top: 10px;
            }

            .pagination a, .pagination span{
             margin-right: 3px;
            }
            .pagination span{
                display: inline-block;
                padding: 3px 8px;
                background: gray;
                color: #fff;
                text-decoration: none;
                margin-top: 10px;
            }
            table.form{
                width: 100%;
            }
            table.form td{
               
                border: solid 1px rgb(19, 17, 17);
                padding: 5px 10px;
                
            }

            table.form td a {
                text-decoration: none;
                color: white;
                background: rgb(30, 30, 30);
                padding: 2px 2px;
                margin: 6px 2px;
                border-radius: 3px;
                /* display: block; */
            }

            #score-table a{
                display: block;
                text-align: center;
            }

            table.form thead{
                font-weight: bold;
                font-size: 18px;

                /* text-align: center; */
            }

            

            .controls{
                margin: 10px 0px;
                text-align: right;
            }

            .form input.long[type="text"]{
               width: 300px;
            }

            .logout{
                padding-right: 40px;
                margin-top: -10px;
                padding-bottom: 6px;
                
                text-align: right !important;
                font-size: 18px;
                font-weight: 600px;
                border-bottom: 1px solid #ccc;
            }

            .logout a {

                text-decoration: none;
                background: rgb(19, 17, 17);
                padding: 5px 10px;
                color: white;
                border-radius: 5px;
                /* font-size: 18px;
                font-weight: 600px; */
            }

            .filter {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .filter form {
                margin-bottom: 3px;
            }

        </style>
        <script src="http://code.jquery.com/jquery-1.9.0.js"></script>
    </head>
    <body class="main">
        <div id="container">
           
            <div id="header">
                <ul>
                    <?php if (is_logged()) { ?> 

                    <?php if (is_supper_admin()){ ?>
                    <li>
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">User</a>
                    </li>
                    <?php } ?>

                    <li>
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'hs', 'a' => 'list')); ?>">Danh sách học sinh</a>
                    </li>

                    <li>
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'diem', 'a' => 'list')); ?>">Tổng hợp điểm</a>
                    </li>

                    <li>
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'gv', 'a' => 'list')); ?>">Danh sách giáo viên</a>
                    </li>
                    
                    <li>
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'message', 'a' => 'list')); ?>">Tin nhắn</a>
                    </li>
                </ul>
                <div class="logout">
                    Xin chào <?php echo get_current_username(); ?> |
                    <a href="<?php echo base_url('admin/?m=common&a=logout'); ?>">Logout</a>
                </div>
            </div>
            <?php } ?>
            <div id="content">