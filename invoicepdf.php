
<?php
require 'fpdf/fpdf.php';
include "connection.php";

if (isset($_GET["invoiceno"])) {

    $invoice_id = $_GET["invoiceno"];
    $datet = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$datet->setTimezone($tz);
$date = $datet->format('Y-m-d H:i:s');
    // Fetch invoice data from database
    $irs = Database::search("SELECT * FROM `invoice` INNER JOIN `customer` ON `customer`.`customer_id`=`invoice`.`customer_id` WHERE `invoice_id` = $invoice_id");

    if ($irs->num_rows > 0) {
        $id = $irs->fetch_assoc();
        $height = 165;

        // Create a new FPDF instance
        $pdf = new FPDF();
        $pdf->AddPage();

        $imagePath = 'resourses/leterhead.jpg'; // Update this with the path to your image file

        // Add the image
        $pdf->Image($imagePath, $x = 0, $y = 0, $w = 210, $h = 297);

        $pdf->Ln(50);
        // Set font
        $pdf->SetFont('Arial', 'BU', 30);

        // Title
        $pdf->Cell(0, 10, 'INVOICE', 0, 1, 'C');

        // Line break
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(110, 8, '', 0, 0);
        $pdf->Cell(30, 8, 'Invoice Date', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, ': ' . $date , 0, 1);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(110, 8, '', 0, 0);
        $pdf->Cell(30, 8, 'Invoice No', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        if (strlen($invoice_id) == 1) {
            $pdf->Cell(0, 8, ': EPS/IN/000' . $invoice_id, 0, 1);
        } else if (strlen($invoice_id) == 2) {
            $pdf->Cell(0, 8, ': EPS/IN/00' . $invoice_id, 0, 1);
        } else if (strlen($invoice_id) == 3) {
            $pdf->Cell(0, 8, ': EPS/IN/0' . $invoice_id, 0, 1);
        } else if (strlen($invoice_id) == 4) {
            $pdf->Cell(0, 8, ': EPS/IN/' . $invoice_id, 0, 1);
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(5, 8, '', 0, 0);
        $pdf->Cell(40, 8, 'Customer Name', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, ': ' . $id['f_name'] . ' ' . $id['l_name'], 0, 1);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(5, 8, '', 0, 0);
        $pdf->Cell(40, 8, 'ID Number', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, ': ' . $id['nic'], 0, 1);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(5, 8, '', 0, 0);
        $pdf->Cell(40, 8, 'Address', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, ': ' . $id['address'], 0, 1);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(5, 8, '', 0, 0);
        $pdf->Cell(40, 8, 'Mobile', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, ': ' . $id['mobile'], 0, 1);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(5, 8, '', 0, 0);
        $pdf->Cell(40, 8, 'System Capacity', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, ': ' . $id['system_capacity'], 0, 1);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(5, 8, '', 0, 0);
        $pdf->Cell(40, 8, 'System Price', 0, 0);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 8, ': Rs.' . $id['i_amount'] . '.00', 0, 1);

        if ($id['discount'] !== '0') {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(5, 8, '', 0, 0);
            $pdf->Cell(40, 8, 'Discount', 0, 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 8, ': Rs.' . $id['discount'] . '.00', 0, 1);

            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(5, 8, '', 0, 0);
            $pdf->Cell(40, 8, 'Discounted Price', 0, 0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 8, ': Rs.' . $id['sub_total'] . '.00', 0, 1);

            $height += 8;
        }
        
        // Line break
        $pdf->Ln(5);

        // Invoice details
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 8, '', 0, 0);
        $pdf->Cell(40, 8, 'Date', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Description', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Method', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Amount(Rs)', 1, 1, 'C');

        $idrs = Database::search("SELECT * FROM `customer_payments` WHERE `customer_id` = '" . $id['customer_id'] . "'");;
        $total = 0;
        $method = "";
        $description = "";
        $counter = 1;
        if ($idrs->num_rows > 0) {
            // Loop through each row
            while ($idd = $idrs->fetch_assoc()) {
                $total += $idd['amount'];
                
                $height += 8;

                if ($idd['payment_methord'] == '1') {
                    $method = "Cheque";
                } else if ($idd['payment_methord'] == '2') {
                    $method = "Cash";
                } else {
                    $method = "Bank Transfer";
                }

                $description = $counter == 1 ? '1st Payment' : ($counter == 2 ? '2nd Payment' : ($counter == 3 ? '3rd Payment' : ($counter == 4 ? '4th Payment' : ($counter == 5 ? '5th Payment' : ($counter == 6 ? '6th Payment' : 'More Payments')))));
                $counter++;
                // Output table row for the current invoice item
                $pdf->SetFont('Arial', '', 12);
                $pdf->Cell(10, 8, '', 0, 0);
                $pdf->Cell(40, 8, $idd['date'], 1, 0, 'C');
                $pdf->Cell(50, 8, $description, 1, 0, 'C');
                $pdf->Cell(40, 8, $method, 1, 0, 'C');
                $pdf->Cell(40, 8, $idd['amount'] . '.00', 1, 1, 'C');
            }
        }

        $due = $id['sub_total'] - $total;
        // Cell Total
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 8, '', 0, 0);
        $pdf->Cell(130, 8, 'Total', 1, 0, 'C');
        $pdf->Cell(40, 8, $total . '.00', 1, 1, 'C');

        if($due >= 1){
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(10, 8, '', 0, 0);
        $pdf->Cell(130, 8, 'Due Amount', 1, 0, 'C');
        $pdf->Cell(40, 8, $due . '.00', 1, 1, 'C');
        }else{
            $height -= 8;
        }

        $pdf->Ln(15);

        if ($id['payment_status_id'] == 1) {
            $imagePath1 = 'resourses/paid.png'; // Update this with the path to your image file

            // Add the image
            $pdf->Image($imagePath1, $x = 155, $y = 95, $w = 40, $h = 40);
        } else {
            $imagePath2 = 'resourses/unpaid.png'; // Update this with the path to your image file

            // Add the image
            $pdf->Image($imagePath2, $x = 150, $y = 95, $w = 45, $h = 45);
        }
        
        $imagePath3 = 'resourses/sign.png'; // Update this with the path to your image file

        // Add the image
        $pdf->Image($imagePath3, $x = 30, $y = $height, $w = 30, $h = 30);
        
        $imagePath4 = 'resourses/seal.png'; // Update this with the path to your image file

        // Add the image
        $pdf->Image($imagePath4, $x = 90, $y = $height, $w = 70);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 7, '', 0, 0);
        $pdf->Cell(40, 7, '................................', 0, 1);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(15, 7, '', 0, 0);
        $pdf->Cell(40, 7, 'R.H.Nalin Ravindra', 0, 1);

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(15, 5, '', 0, 0);
        $pdf->Cell(40, 5, ' Managing Director', 0, 1);

        // Output PDF
        $pdf->Output();
    } else {
        echo "0 results";
    }
}

?>


