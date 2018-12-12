
<?php 

  	error_reporting(0);
    require("assets/fpdf/fpdf/fpdf.php");
    $pdf = new FPDF('L','mm',array(216,330));
    $pdf->AddPage();
    $pdf->SetFont("times","B", "15");
    $pdf->Cell(0,5, "Headcount Report",0,5,'C');
    $pdf->SetFont("times","", "11");
    $pdf->Cell(0,5, "Date Generated: ".@date('M d, Y'),0,5,'L');
    $pdf->Cell(0,10, "From: ".@date_format(@date_create(htmlspecialchars(trim($this->input->get('from', TRUE)))), 'M d, Y')." to ". @date_format(@date_create(htmlspecialchars(trim($this->input->get('to', TRUE)))), 'M d, Y'),0,5,'L');
    $pdf->Cell(0,5,"",0,5,'L');
   
    $pdf->SetFont("Times", "B", "11");
   	$pdf->Cell(75,5, "CLIENT NAME",1 ,0, 'C');
    $pdf->Cell(80,5, "JOBS",1 ,0, 'C');
   	$pdf->Cell(15,5, "HC",1 ,0, 'C');
   	$pdf->Cell(25,5, "COST/TITLE",1 ,0, 'C');
   	$pdf->Cell(30,5, "TOTAL COST",1 ,0, 'C');
    $pdf->Cell(20,5, "HOURS",1 ,0, 'C');
    $pdf->Cell(25,5, "TIMEZONE",1 ,0, 'C');
    $pdf->Cell(20,5, "SHIFT",1 ,0, 'C');
    $pdf->Cell(25,5, "LOCATION",1 ,1, 'C');
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
                $pdf->Cell(75,5, "",1 ,0, 'C');
                $hc_ttl += $headcount[$count]->hc;
                $ct_ttl += $headcount[$count]->cost_per_title;
                $ttl_c  += $headcount[$count]->ttl_cost;
            }
            else
            {
                $pdf->SetFont("Times", "B", "11");
                $pdf->Cell(75,5, $row->client_name,1 ,0, 'L');
            }
                $pdf->SetFont("Times", "", "11");
                $pdf->Cell(80,5, $row->jobtitle,1 ,0, 'L');
                $pdf->Cell(15,5, $row->hc,1 ,0, 'R');
                $pdf->Cell(25,5, number_format($row->cost_per_title,2),1 ,0, 'R');
                $pdf->Cell(30,5, number_format($row->ttl_cost,2),1 ,0, 'R');
                $pdf->Cell(20,5, $row->hours_work,1 ,0, 'C');
                $pdf->Cell(25,5, $row->timezone,1 ,0, 'C');
                $pdf->Cell(20,5, $row->shift,1 ,0, 'C');
                $pdf->Cell(25,5, $row->location,1 ,1, 'C');
            if($headcount[$temp]->client_name != $headcount[$count2]->client_name)
            {
                $hc_ttl += $headcount[$temp]->hc;
                $ct_ttl += $headcount[$temp]->cost_per_title;
                $ttl_c  += $headcount[$temp]->ttl_cost;
                $pdf->SetFont("Times", "B", "11");
                $pdf->Cell(75,5, "TOTAL",1 ,0, 'L');
                $pdf->Cell(80,5, "",1 ,0, 'C');
                $pdf->Cell(15,5, $hc_ttl,1 ,0, 'R');
                $pdf->Cell(25,5, number_format($ct_ttl,2),1 ,0, 'R');
                $pdf->Cell(30,5, number_format($ttl_c,2),1 ,0, 'R');
                $pdf->Cell(20,5, "",1 ,0, 'C');
                $pdf->Cell(25,5, "",1 ,0, 'C');
                $pdf->Cell(20,5, "",1 ,0, 'C');
                $pdf->Cell(25,5, "",1 ,1, 'C');
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
            $pdf->SetFont("Times", "B", "11");
            $pdf->Cell(75,5, "Over All Total",1 ,0, 'L');
            $pdf->Cell(80,5, "",1 ,0, 'C');
            $pdf->Cell(15,5, $all_hc,1 ,0, 'R');
            $pdf->Cell(25,5, number_format($all_ct,2),1 ,0, 'R');
            $pdf->Cell(30,5, number_format($all_tc,2),1 ,0, 'R');
            $pdf->Cell(20,5, "",1 ,0, 'C');
            $pdf->Cell(25,5, "",1 ,0, 'C');
            $pdf->Cell(20,5, "",1 ,0, 'C');
            $pdf->Cell(25,5, "",1 ,1, 'C');
    }
    
    $pdf->output();
?>