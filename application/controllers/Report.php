<?php
ini_set('memory_limit','-1');
set_time_limit(300); // 5 menit untuk reporting jumlah besar
defined('BASEPATH') or exit('No direct script access allowed');

// load package composer
require 'vendor/autoload.php';
// deklarasi package yang ingin digunakan
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_report'); 
        // $this->user_login->cek_login();  // validasi url agar cek login dulu
    }

    // data pairing
    public function index()
    {
        $data = array(
            'title' => 'Generate Report Pairing',
            'isi' => 'report/v_datareportpairing'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    public function generatereportpairing()
    {
        $id_sts = $this->session->userdata('id_sts'); 
        $date_a = $this->input->post("date_a");
        $date_b = $this->input->post("date_b");
        $flightno = trim(strtoupper($this->input->post("flightno")));
        
        $data = $this->m_report->tampilpairing($date_a, $date_b, $flightno, $id_sts);
        
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        // protect password length <= 24
        // $protection = $activeWorksheet->getProtection();
        // $protection->setPassword("jasab2023");
        // $protection->setSheet(true);
        
        $activeWorksheet->mergeCells('A1:M1')->setCellValue('A1', 'PAIRING FLIGHT REPORTS');
        $activeWorksheet->getStyle('A1')->getFont()->setSize(20);
        $activeWorksheet->getStyle('A1:M1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:M1')->getAlignment()->setHorizontal('center');

        // center header
        $activeWorksheet->getStyle('A4:M4')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A5:M5')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A6:M6')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A4:M4')->getAlignment()->setVertical('center');
        $activeWorksheet->getStyle('A5:M5')->getAlignment()->setVertical('center');
        $activeWorksheet->getStyle('A6:M6')->getAlignment()->setVertical('center');

        // merge header
        $activeWorksheet->mergeCells('A4:A6');
        $activeWorksheet->mergeCells('B4:B6');
        $activeWorksheet->mergeCells('C4:C6');
        $activeWorksheet->mergeCells('D4:D6');
        $activeWorksheet->mergeCells('E4:E6');
        $activeWorksheet->mergeCells('F4:F6');
        $activeWorksheet->mergeCells('G4:G6');
        $activeWorksheet->mergeCells('H4:H6');
        $activeWorksheet->mergeCells('I4:I6');
        $activeWorksheet->mergeCells('J4:J6');
        $activeWorksheet->mergeCells('K4:K6');
        $activeWorksheet->mergeCells('L4:L6');
        $activeWorksheet->mergeCells('M4:M6');

        $activeWorksheet->setCellValue('A4', 'NO');
        $activeWorksheet->setCellValue('B4', 'ARR FLIGHT NO');
        $activeWorksheet->setCellValue('C4', 'DEP FLIGHT NO');
        $activeWorksheet->setCellValue('D4', 'STA DATE');
        $activeWorksheet->setCellValue('E4', 'STA TIME');
        $activeWorksheet->setCellValue('F4', 'STD DATE');
        $activeWorksheet->setCellValue('G4', 'STD TIME');
        $activeWorksheet->setCellValue('H4', 'BAY');
        $activeWorksheet->setCellValue('I4', 'ACTYPE');
        $activeWorksheet->setCellValue('J4', 'ACREG');
        $activeWorksheet->setCellValue('K4', 'ORIGIN');
        $activeWorksheet->setCellValue('L4', 'STATION');
        $activeWorksheet->setCellValue('M4', 'DESTINATION');

        $num = 1;
        $column = 7;
        foreach ($data as $key => $value) {
            $activeWorksheet->setCellValue('A'.$column, ($num));
            $activeWorksheet->setCellValue('B'.$column, $value->arr_flightno);
            $activeWorksheet->setCellValue('C'.$column, $value->dep_flightno);
            $activeWorksheet->setCellValue('D'.$column, date('d/m/Y', strtotime($value->arr_sta)));
            $activeWorksheet->setCellValue('E'.$column, date('H:i:s', strtotime($value->arr_sta)));
            $activeWorksheet->setCellValue('F'.$column, date('d/m/Y', strtotime($value->dep_std)));
            $activeWorksheet->setCellValue('G'.$column, date('H:i:s', strtotime($value->dep_std)));
            $activeWorksheet->setCellValue('H'.$column, $value->arr_bay .'/'. $value->dep_bay);
            $activeWorksheet->setCellValue('I'.$column, $value->arr_actype);
            $activeWorksheet->setCellValue('J'.$column, $value->arr_acreg);
            $activeWorksheet->setCellValue('K'.$column, $value->arr_origin);
            $activeWorksheet->setCellValue('L'.$column, $value->arr_destination);
            $activeWorksheet->setCellValue('M'.$column, $value->dep_destination);
            
            $num++;
            $column++;
        }

        $activeWorksheet->getStyle('A4:M4')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A4:M4')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A4:M'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getStyle('A5:M5')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A5:M5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A5:M'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getStyle('A6:M6')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A6:M6')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A6:M'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('J')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('K')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('L')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('M')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=pairingflightreport.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();   
    } 
    
    // data arrival
    public function arrival()
    {
        $data = array(
            'title' => 'Generate Report Arrival',
            'isi' => 'report/v_datareportarrival'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    public function generatereportarrival()
    {
        $id_sts = $this->session->userdata('id_sts'); 
        $date_a = $this->input->post("date_a");
        $date_b = $this->input->post("date_b");
        $flightno = trim(strtoupper($this->input->post("flightno")));
        
        $data = $this->m_report->tampilarrival($date_a, $date_b, $flightno, $id_sts);
        
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        // protect password length <= 24
        // $protection = $activeWorksheet->getProtection();
        // $protection->setPassword("jasab2023");
        // $protection->setSheet(true);
        
        $activeWorksheet->mergeCells('A1:I1')->setCellValue('A1', 'ARRIVAL FLIGHT REPORTS');
        $activeWorksheet->getStyle('A1')->getFont()->setSize(20);
        $activeWorksheet->getStyle('A1:I1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');

        // center header
        $activeWorksheet->getStyle('A4:I4')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A5:I5')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A6:I6')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A4:I4')->getAlignment()->setVertical('center');
        $activeWorksheet->getStyle('A5:I5')->getAlignment()->setVertical('center');
        $activeWorksheet->getStyle('A6:I6')->getAlignment()->setVertical('center');

        // merge header
        $activeWorksheet->mergeCells('A4:A6');
        $activeWorksheet->mergeCells('B4:B6');
        $activeWorksheet->mergeCells('C4:C6');
        $activeWorksheet->mergeCells('D4:D6');
        $activeWorksheet->mergeCells('E4:E6');
        $activeWorksheet->mergeCells('F4:F6');
        $activeWorksheet->mergeCells('G4:G6');
        $activeWorksheet->mergeCells('H4:H6');
        $activeWorksheet->mergeCells('I4:I6');

        $activeWorksheet->setCellValue('A4', 'NO');
        $activeWorksheet->setCellValue('B4', 'ARR FLIGHT NO');
        $activeWorksheet->setCellValue('C4', 'STA DATE');
        $activeWorksheet->setCellValue('D4', 'STA TIME');
        $activeWorksheet->setCellValue('E4', 'BAY');
        $activeWorksheet->setCellValue('F4', 'ACTYPE');
        $activeWorksheet->setCellValue('G4', 'ACREG');
        $activeWorksheet->setCellValue('H4', 'ORIGIN');
        $activeWorksheet->setCellValue('I4', 'DESTINATION');

        $num = 1;
        $column = 7;
        foreach ($data as $key => $value) {
            $activeWorksheet->setCellValue('A'.$column, ($num));
            $activeWorksheet->setCellValue('B'.$column, $value->arr_flightno);
            $activeWorksheet->setCellValue('C'.$column, date('d/m/Y', strtotime($value->arr_sta)));
            $activeWorksheet->setCellValue('D'.$column, date('H:i:s', strtotime($value->arr_sta)));
            $activeWorksheet->setCellValue('E'.$column, $value->arr_bay);
            $activeWorksheet->setCellValue('F'.$column, $value->arr_actype);
            $activeWorksheet->setCellValue('G'.$column, $value->arr_acreg);
            $activeWorksheet->setCellValue('H'.$column, $value->arr_origin);
            $activeWorksheet->setCellValue('I'.$column, $value->arr_destination);
            
            $num++;
            $column++;
        }

        $activeWorksheet->getStyle('A4:I4')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A4:I4')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A4:I'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getStyle('A5:I5')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A5:I5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A5:I'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getStyle('A6:I6')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A6:I6')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A6:I'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=arrivalflightreport.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();   
    } 

    // data departure
    public function departure()
    {
        $data = array(
            'title' => 'Generate Report Departure',
            'isi' => 'report/v_datareportdeparture'
        );
        $this->load->view('admin-layout/v_wrapper', $data, FALSE);
    }

    public function generatereportdeparture()
    {
        $id_sts = $this->session->userdata('id_sts'); 
        $date_a = $this->input->post("date_a");
        $date_b = $this->input->post("date_b");
        $flightno = trim(strtoupper($this->input->post("flightno")));
        
        $data = $this->m_report->tampildeparture($date_a, $date_b, $flightno, $id_sts);
        
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        // protect password length <= 24
        // $protection = $activeWorksheet->getProtection();
        // $protection->setPassword("jasab2023");
        // $protection->setSheet(true);
        
        $activeWorksheet->mergeCells('A1:I1')->setCellValue('A1', 'DEPARTURE FLIGHT REPORTS');
        $activeWorksheet->getStyle('A1')->getFont()->setSize(20);
        $activeWorksheet->getStyle('A1:I1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');

        // center header
        $activeWorksheet->getStyle('A4:I4')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A5:I5')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A6:I6')->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('A4:I4')->getAlignment()->setVertical('center');
        $activeWorksheet->getStyle('A5:I5')->getAlignment()->setVertical('center');
        $activeWorksheet->getStyle('A6:I6')->getAlignment()->setVertical('center');

        // merge header
        $activeWorksheet->mergeCells('A4:A6');
        $activeWorksheet->mergeCells('B4:B6');
        $activeWorksheet->mergeCells('C4:C6');
        $activeWorksheet->mergeCells('D4:D6');
        $activeWorksheet->mergeCells('E4:E6');
        $activeWorksheet->mergeCells('F4:F6');
        $activeWorksheet->mergeCells('G4:G6');
        $activeWorksheet->mergeCells('H4:H6');
        $activeWorksheet->mergeCells('I4:I6');

        $activeWorksheet->setCellValue('A4', 'NO');
        $activeWorksheet->setCellValue('B4', 'DEP FLIGHT NO');
        $activeWorksheet->setCellValue('C4', 'STD DATE');
        $activeWorksheet->setCellValue('D4', 'STD TIME');
        $activeWorksheet->setCellValue('E4', 'BAY');
        $activeWorksheet->setCellValue('F4', 'ACTYPE');
        $activeWorksheet->setCellValue('G4', 'ACREG');
        $activeWorksheet->setCellValue('H4', 'ORIGIN');
        $activeWorksheet->setCellValue('I4', 'DESTINATION');

        $num = 1;
        $column = 7;
        foreach ($data as $key => $value) {
            $activeWorksheet->setCellValue('A'.$column, ($num));
            $activeWorksheet->setCellValue('B'.$column, $value->dep_flightno);
            $activeWorksheet->setCellValue('C'.$column, date('d/m/Y', strtotime($value->dep_std)));
            $activeWorksheet->setCellValue('D'.$column, date('H:i:s', strtotime($value->dep_std)));
            $activeWorksheet->setCellValue('E'.$column, $value->dep_bay);
            $activeWorksheet->setCellValue('F'.$column, $value->dep_actype);
            $activeWorksheet->setCellValue('G'.$column, $value->dep_acreg);
            $activeWorksheet->setCellValue('H'.$column, $value->dep_origin);
            $activeWorksheet->setCellValue('I'.$column, $value->dep_destination);
            
            $num++;
            $column++;
        }

        $activeWorksheet->getStyle('A4:I4')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A4:I4')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A4:I'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getStyle('A5:I5')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A5:I5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A5:I'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getStyle('A6:I6')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A6:I6')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                    ],
            ],
        ];
        $activeWorksheet->getStyle('A6:I'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('H')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('I')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=departureflightreport.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();   
    } 
}
