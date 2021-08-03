<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Comprovativopdf extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('is_logged_in') !== TRUE) {
            redirect('login');
        }
    }

    public function fornecimento_material($id_fornecimento)
    {
        $this->load->model('fornecimento_model');
        $fornecimento = $this->fornecimento_model->get_fornecimento_instalacao($id_fornecimento);
        $artigos = $this->fornecimento_model->get_fornecimento_artigos($id_fornecimento);

        $this->load->library('Pdf');

        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setData($fornecimento['id_fornecimento'], $fornecimento['fechado_nome'], $fornecimento['data_fecho']);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('SafetyMarket');
        $pdf->SetTitle('Comprovativo Movimento');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, '', '');

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->AddPage();

        $data = array(
            'fornecimento' => $fornecimento,
            'artigos' =>$artigos
        );

        $html = $this->load->view('comprovativo_material', $data, TRUE);
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Comprovativo.pdf', 'I');
    }
}
