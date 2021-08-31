<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<title>Vinda SFA Outlet QR Code</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            /** Define the margins of your page **/
            @page {
                margin: 100px 50px 10px;
				font: 13px arial, sans-serif;
            }
			
			body {
                margin-top: 1cm;
                margin-left: .7cm;
                margin-right: .7cm;
                margin-bottom: 1cm;
            }
			

            header {
                position: fixed;
                top: -50px;
                left: 0px;
                right: 0px;
                height: 100px;

                /** Extra personal styles 
                background-color: #03a9f4;**/
                color: black;
                text-align: center;
                line-height: 30px;
				font: 15px arial bold, sans-serif;
            }
			
			
			div {
                position: absolute;
                top: 20px;
                left: 20px;
                right: 20px;
				bottom: -60px;
                height: 30px;

                /** Extra personal styles 
                background-color: #03a9f4;**/
                color: black;
                text-align: justify;
                line-height: 30px;
				font: 13px arial, sans-serif;
            }
			
			.page-number:after {
				font-weight: 700;
				content: "Page " counter(page);
			}
			
			.page-break {
				page-break-after: always;
			}
			
			
			
        </style>
    </head>
    <body>
		 
        <!-- Define header and footer blocks before your div -->
        <header>
           <!-- content -->
        </header>
		
		<main>
        <!-- Wrap the div of your PDF inside a main tag -->
			
			<table border="0" width="100%" cellspacing="0" cellpadding="3" style="text-align:center">
			<tr>
				<td>
					<img src ="../public/images/text.png" width="330px">
				</td>
			</tr>
			<tr>
				<td>
					<img src ="../public/qr_code/{{$outlets->id}}.png" height="300px">
				</td>
			</tr>
			<tr>
				<td width="30%">
					<span style="font-size:23px"><b>Outlet ID: {{ str_pad($outlets->id, 11, '0', STR_PAD_LEFT) }}</b></span>
				</td>
			</tr>
			<!--<tr>
				<td width="30%">Signature</td>
				<td></td>
			</tr>-->
			</table><br>
		  
		</main>
		<script type="text/php">
			// if (isset($pdf)) {
				// $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
				// $size = 10;
				// $font = $fontMetrics->getFont("Verdana");
				// $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
				// $x = ($pdf->get_width() - $width) / 2;
				// $y = $pdf->get_height() - 35;
				// $pdf->page_text($x, $y, $text, $font, $size);
			// }
		</script>

    </body>
</html>