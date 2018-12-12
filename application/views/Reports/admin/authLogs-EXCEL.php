<?php 
    // error_reporting(0);
    require("assets/PHPExcel/Classes/PHPExcel.php");
    ob_end_clean();
    $objPHPExcel = new PHPExcel();

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="authentication logs.xls"');
    header('Cache-Control: max-age=0');

    foreach(range('A','E') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
    }
    
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getStyle('1:7')->getFont()->setBold(true);

    $rowCount = 1;
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'AUTHENTICATION LOGS');
    $rowCount++;
    $rowCount++;
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Date Generated:');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, @date('M d, Y'));
    $rowCount++;
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'From:');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, @date_format(@date_create(htmlspecialchars(trim($this->input->get('from', TRUE)))), 'M d, Y'));
    $rowCount++;
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'To:');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, @date_format(@date_create(htmlspecialchars(trim($this->input->get('to', TRUE)))), 'M d, Y'));
    $rowCount = 7;
    
    
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'USER');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'IP ADDRESS');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'ACTION');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'RESULT');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'DATETIME');
    $rowCount = 8;

    if(!empty($auth_logs))
    {
        foreach($auth_logs as $row)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->last_name.", ".$row->first_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->ip_address);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->action);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, (($row->result == 0)? "Failure login" : "Successful login"));
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, @date_format(@date_create($row->created), 'M d, Y h:s a'));
            $rowCount++;
        }
    }

    $objPHPExcel->getActiveSheet()
    ->getStyle('A9:A10000')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $objPHPExcel->getActiveSheet()
    ->getStyle('B9:B10000')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $objPHPExcel->getActiveSheet()
    ->getStyle('C9:C10000')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $objPHPExcel->getActiveSheet()
    ->getStyle('D9:D10000')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $objPHPExcel->getActiveSheet()
    ->getStyle('E9:D10000')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    

    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
    // ob_end_clean();
    $objWriter->save('php://output');
?>