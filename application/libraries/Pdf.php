<?php
defined('BASEPATH') or exit('No direct script access allowed');


require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{

    function __construct()
    {
        //parent::__construct();
        TCPDF::__construct(
            $orientation = 'P',
            $unit = 'mm',
            $format = 'A4',
            $unicode = true,
            $encoding = 'UTF-8',
            $diskcache = false,
            $pdfa = false
        );
    }

    public function setData($n_doc, $fechado_por, $data_fecho){
        $this->n_doc = null;
        $this->fechado_por = null;
        $this->data_fecho = null;
        $this->n_doc = $n_doc;
        $this->fechado_por = $fechado_por;
        $this->data_fecho = $data_fecho;
    }

    public function Header()
    {
        // Logo
        $image_file = K_PATH_IMAGES . 'logo_example.jpg';
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 10);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $html = '<table style="border-collapse: collapse; width: 100%; height: 54px;" border="2">
        <tbody>
        <tr style="height: 10px;">
        <td style="width: 30%; height: 54px; text-align:center; vertical-align: middle;" rowspan="3"><img alt="logo" width="1000%" src="./recourses/images/logo/ptfire.png"><br><span style="font-size:8px">(+351) 234 246 213 </span></td>
        <td style="width: 40%; text-align: center; height: 54px;" rowspan="3"><strong><br>Comprovativo de <br> Fornecimento Material</strong><strong><br /></strong></td>
        <td style="width: 30%; height: 10px;"><strong> Doc. N&ordm;</strong> '.$this->n_doc.'</td>
        </tr>
        <tr style="height: 22px;">
        <td style="width: 30%; height: 22px;"><strong> Emiss&atilde;o:</strong> '.$this->fechado_por.'</td>
        </tr>
        <tr style="height: 22px;">
        <td style="width: 30%; height: 22px;"><strong> Data:</strong> '.$this->data_fecho.'</td>
        </tr>
        </tbody>
        </table>';

        $this->writeHTML($html);
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-11);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // Position at 15 mm from bottom
        $this->SetY(-16);

        $htmlFooter=
            '<table style="border-collapse: collapse; width: 100%; text-align:center" border="1">
                <tbody>
                    <tr>
                        <td style="width: 100%;">
                            <b>Rua Vale da Lage, nº6 Fração C | 3850-200 Albergaria-a-Velha, Aveiro, Portugal • info@ptfire.com.pt • www.ptfire.com.pt • <br> (+351) 234 105 418</b>
                        </td>
                    </tr>
                </tbody>
            </table>';
        $this->writeHTML($htmlFooter);
    }


    public function AcceptPageBreak()
    {
        if (1 == $this->PageNo()) {
            $this->SetMargins(15, 44, 20, true);
        }
        if ($this->num_columns > 1) {
            // multi column mode
            if ($this->current_column < ($this->num_columns - 1)) {
                // go to next column
                $this->selectColumn($this->current_column + 1);
            } elseif ($this->AutoPageBreak) {
                // add a new page
                $this->AddPage();
                // set first column
                $this->selectColumn(0);
            }
            // avoid page breaking from checkPageBreak()
            return false;
        }
        return $this->AutoPageBreak;
    }
}
