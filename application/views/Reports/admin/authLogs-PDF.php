
<?php 

  	error_reporting(0);
    require("assets/fpdf/fpdf/fpdf.php");
    $pdf = new FPDF('L','mm',array(216,330));
    $pdf->AddPage();
    $pdf->SetFont("times","B", "15");
    $pdf->Cell(0,5, "Authentication Logs",0,5,'C');
    $pdf->SetFont("times","", "11");
    $pdf->Cell(0,5, "Date Generated: ".@date('M d, Y'),0,5,'L');
    $pdf->Cell(0,10, "From: ".@date_format(@date_create(htmlspecialchars(trim($this->input->get('from', TRUE)))), 'M d, Y')." to ". @date_format(@date_create(htmlspecialchars(trim($this->input->get('to', TRUE)))), 'M d, Y'),0,5,'L');
    $pdf->Cell(0,5,"",0,5,'L');
   
    $pdf->SetFont("Times", "B", "11");
   	$pdf->Cell(105,5, "USER",1 ,0, 'C');
    $pdf->Cell(50,5, "IP ADDRESS",1 ,0, 'C');
   	$pdf->Cell(60,5, "ACTION",1 ,0, 'C');
   	$pdf->Cell(50,5, "RESULT",1 ,0, 'C');
   	$pdf->Cell(45,5, "DATETIME",1 ,1, 'C');
    if(!empty($auth_logs))
    {
        foreach($auth_logs as $row)
        {
            $pdf->SetFont("Times", "", "11");
            $pdf->Cell(105,5, $row->last_name.", ".$row->first_name,1 ,0, 'L');
            $pdf->Cell(50,5,  $row->ip_address,1 ,0, 'L');
            $pdf->Cell(60,5,  $row->action,1 ,0, 'L');
            $pdf->Cell(50,5,  (($row->result == 0)? "Failure login" : "Successful login"),1 ,0, 'L');
            $pdf->Cell(45,5,  @date_format(@date_create($row->created), 'M d, Y h:s a'),1 ,1, 'L');
        }
    }
    
    $pdf->output();
?>