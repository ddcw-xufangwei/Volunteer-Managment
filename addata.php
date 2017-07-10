<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<div class="mainarea">

<?php
        //判断文件类型，如果不是"xls"或者"xlsx"，则退出
        if ( $_FILES["file"]["type"] == "application/vnd.ms-excel" ){
                $inputFileType = 'Excel5';
        }
        elseif ( $_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" ){
                $inputFileType = 'Excel2007';
        }
        else {
                echo "Type: " . $_FILES["file"]["type"] . "<br />";
                echo "Invalid file type";
                exit();
        }
        
        if ($_FILES["file"]["error"] > 0)
        {
                echo "Error: " . $_FILES["file"]["error"] . "<br />";
                exit();
        }

        $inputFileName = "uploadData/" . $_FILES["file"]["name"];
        if (file_exists($inputFileName))
        {
                //echo $_FILES["file"]["name"] . " already exists. <br />";
                unlink($inputFileName);    //如果服务器上存在同名文件，则删除
        }
        else
        {
        }
        move_uploaded_file($_FILES["file"]["tmp_name"],        $inputFileName);
        echo "Stored in: " . $inputFileName;
        
        //连接数据库
        include_once 'conn.php';

        //导入phpExcel
        include_once 'Classes/PHPExcel/IOFactory.php';
        
        //设置php服务器可用内存，上传较大文件时可能会用到
        ini_set('memory_limit', '10M');
        
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        
        $WorksheetInfo = $objReader->listWorksheetInfo($inputFileName);

        //读取文件最大行数、列数，偶尔会用到。
        $maxRows = $WorksheetInfo[0]['totalRows'];
        $maxColumn = $WorksheetInfo[0]['totalColumns'];     
        //列数可用于粗略判断所上传文件是否符合模板要求
        
        //设置只读，可取消类似"3.08E-05"之类自动转换的数据格式，避免写库失败
        $objReader->setReadDataOnly(true);
        
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
        //excel2003文件，可使用'$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);'
        //excel2007文件使用"getActiveSheet()"方法时会提示出错：对non-object使用了"toArray"方法。
        //才疏学浅，原因未明。。。


        //获取表头，并判断是否符合格式
        $keywords = $sheetData[1];
        $warning = '上传文件格式不正确，请修改后重新上传！<br />';
        $columns = array ( 'A', 'B', 'C', 'D', 'E', 'F', 'G' );
        $keysInFile = array ( 'KEY1', 'KEY2', 'KEY3', 'KEY4', 'KEY5', 'KEY6', 'KEY7' );
        foreach( $columns as $keyIndex => $columnIndex ){
                if ( $keywords[$columnIndex] != $keysInFile[$keyIndex] ){
                        echo $warning . $columnIndex . '列应为' . $keysInFile[$keyIndex] . '，而非' . $keywords[$columnIndex];
                        exit();
                }
        }
        
        //数据库字段
        $keywords = array ( 'key1', 'key2', 'key3', 'key4', 'key5', 'key6', 'key7' );
        
        //设置数据库字符集
        mysql_query("set names utf8");

        foreach ( $sheetData as $key => $words ){
                if ( $key != 1 ){
                        //忽略表头
                        $query = "insert into fcopy (" . implode( $keywords, "," ) . ") values ('" . implode ( $words, "','" ) . "')";
                        if ( ! ($result = mysql_query ( $query ) ) ){
                                echo '第' . $key . '行数据导入错误' . mysql_error();
                                exit();
                        }
                }
                else {
                }
        }
        echo '<br />数据导入完毕。<br />';
?>




</div>
</html>
