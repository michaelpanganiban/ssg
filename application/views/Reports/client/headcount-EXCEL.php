<?php 
    // error_reporting(0);
    require("assets/PHPExcel/Classes/PHPExcel.php");
    ob_end_clean();
    $objPHPExcel = new PHPExcel();

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="headcount report.xls"');
    header('Cache-Control: max-age=0');

    foreach(range('A','E') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
    }
    
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->getStyle('1:7')->getFont()->setBold(true);

    $rowCount = 1;
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'HEADCOUNT REPORT');
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
    
    
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'CLIENT NAME');
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'JOBS');
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'HEADCOUNT');
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'COST PER TITLE');
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'TOTAL COST');
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'WORKING HOURS');
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'TIMEZONE');
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'SHIFT');
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'LOCATION');
    $rowCount = 8;

    if(!empty($headcount))
    {
        error_reporting(0);
        $count  = -1;
        $count2 = 1;
        $temp   = 0;
        $hc_ttl = 0;
        $ct_ttl = 0;
        $ttl_c  = 0;
        foreach($headcount as $row)
        {
            if($headcount[$temp]->client_name == $headcount[$count]->client_name)
            {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '');
                $hc_ttl += $headcount[$count]->hc;
                $ct_ttl += $headcount[$count]->cost_per_title;
                $ttl_c  += $headcount[$count]->ttl_cost;
            }
            else
            {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row->client_name);
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row->jobtitle);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row->hc);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($row->cost_per_title,2));
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($row->ttl_cost,2));
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row->hours_work);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row->timezone);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row->shift);
            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row->location);
            $rowCount++;
            if($headcount[$temp]->client_name != $headcount[$count2]->client_name)
            {
                $hc_ttl += $headcount[$temp]->hc;
                $ct_ttl += $headcount[$temp]->cost_per_title;
                $ttl_c  += $headcount[$temp]->ttl_cost;
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->getFill()
                                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFE8E5E5');
                    $objPHPExcel->getActiveSheet()->getStyle($rowCount)->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Total');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $hc_ttl);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($ct_ttl,2));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($ttl_c,2));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, '');
                    $rowCount++;
                $all_hc += $hc_ttl;
                $all_ct += $ct_ttl;
                $all_tc += $ttl_c;
                $hc_ttl = 0;
                $ct_ttl = 0;
                $ttl_c  = 0;
            }
            $count2++;
            $count++;
            $temp++;
        }
        $objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':I'.$rowCount)->getFill()
                                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                ->getStartColor()->setARGB('FFE8E5E5');
        $objPHPExcel->getActiveSheet()->getStyle($rowCount)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Overall Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $all_hc);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, number_format($all_ct,2));
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, number_format($all_tc,2));
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, '');
        $rowCount++;
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
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $objPHPExcel->getActiveSheet()
    ->getStyle('D9:D10000')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    $objPHPExcel->getActiveSheet()
    ->getStyle('E9:D10000')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    

    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
    // ob_end_clean();
    $objWriter->save('php://output');

?>