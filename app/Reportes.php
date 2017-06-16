<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Anouar\Fpdf\Facades\Fpdf;
use PHPExcel_Cell_DataType;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Style_Fill;
use Datetime;

class Reportes extends Model
{

    public function scopeReporteProductosPDF($query,$productos,$tiposucursal,$sucursal,$area,$tipoequipo,$marca,$modelo,$ingreso,$proveedor) {
        Fpdf::AddPage('L','A4');
        
        $borde = 0;
        $espacio = 5;
        $restante = 232;
        $filtros = 0;
        $total = 9;
        $filas = 34;
        $multiplo = 4.2;
        $hoja = 2;
        
        
        Fpdf::SetAutoPageBreak(true,1);  
        
        Fpdf::SetFont('Arial','B',12);
        $x=8;
        $y=10;
        Fpdf::SetXY($x,$y);
        Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS - HOJA 1'),$borde,0,'C');
        
        Fpdf::SetXY($x,$y=$y+10);
        Fpdf::SetFont('Arial','B',10);
        
        if($tiposucursal>0){
            $filtros++;
        }
        if($sucursal>0){
            $filtros++;
        }
        if($area>0){
            $filtros++;
        }
        if($tipoequipo>0){
            $filtros++;
        }
        if($marca>0){
            $filtros++;
        }
        if($modelo>0){
            $filtros++;
        }
        if($ingreso!="X"){
            $filtros++;
        }
        if($ingreso=="A"){
            $filtros++;
        }
        if($proveedor>0){
            $filtros++;
        }
        
        $ancho = $restante/($total-$filtros);
        
        Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
        if(!$tiposucursal>0){
            Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO SUC.'),1,0,'C');
        }
        if(!$sucursal>0){
            Fpdf::Cell($ancho,$espacio,utf8_decode('SUCURSAL'),1,0,'C');
        }
        if(!$area>0){
            Fpdf::Cell($ancho,$espacio,utf8_decode('ÁREA'),1,0,'C');
        }
        if(!$tipoequipo>0){
            Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
        }
        if(!$marca>0){
            Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
        }
        if(!$modelo>0){
            Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
        }
        if($ingreso=="X"){
            Fpdf::Cell($ancho,$espacio,utf8_decode('INGRESO'),1,0,'C');
        }
        if($ingreso!="A"){
            Fpdf::Cell($ancho,$espacio,utf8_decode('CONTRATO'),1,0,'C');
        }
        if(!$proveedor>0){
            Fpdf::Cell($ancho,$espacio,utf8_decode('PROVEEDOR'),1,0,'C');
        }
        Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
        
        
        $cant =0;
        foreach ($productos as $producto) {
            $cant = $cant +1;
            if($cant%$filas==0){
                Fpdf::AddPage('L','A4');
                Fpdf::SetFont('Arial','B',12);
                $x=8;
                $y=10;
                Fpdf::SetXY($x,$y);
                Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS - HOJA '.$hoja++),$borde,0,'C');

                Fpdf::SetXY($x,$y=$y+10);
                Fpdf::SetFont('Arial','B',10);
                
                Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
                if(!$tiposucursal>0){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO SUC.'),1,0,'C');
                }
                if(!$sucursal>0){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('SUCURSAL'),1,0,'C');
                }
                if(!$area>0){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('ÁREA'),1,0,'C');
                }
                if(!$tipoequipo>0){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
                }
                if(!$marca>0){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
                }
                if(!$modelo>0){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
                }
                if($ingreso=="X"){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('INGRESO'),1,0,'C');
                }
                if($ingreso!="A"){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('CONTRATO'),1,0,'C');
                }
                if(!$proveedor>0){
                    Fpdf::Cell($ancho,$espacio,utf8_decode('PROVEEDOR'),1,0,'C');
                }
                Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
            }
            Fpdf::SetXY($x,$y=$y+$espacio);
            
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(10,$espacio,utf8_decode($cant),1,0,'C');
            if(!$tiposucursal>0){
                $lng = strlen($producto->nombretiposucursal);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombretiposucursal),1,0,'C');
            }
            Fpdf::SetFont('Arial','',8);
            if(!$sucursal>0){
                $lng = strlen($producto->nombresucursal);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombresucursal),1,0,'C');
            }
            if(!$area>0){
                if($producto->nombrearea==null){
                    $producto->nombrearea = "SIN ÁREA";
                }
                $lng = strlen($producto->nombrearea);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombrearea),1,0,'C');
            }
            if(!$tipoequipo>0){
                $lng = strlen($producto->nombretipoequipo);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombretipoequipo),1,0,'C');
            }
            if(!$marca>0){
                $lng = strlen($producto->nombremarca);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremarca),1,0,'C');
            }
            if(!$modelo>0){
                $lng = strlen($producto->nombremodelo);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremodelo),1,0,'C');
            }
            if($ingreso=="X"){
                if($producto->tipocontrato=="C"){
                    $tipocontrato = "CONTRATO";
                }else{
                    $tipocontrato = "ADQUISICION";
                }
                $lng = strlen($tipocontrato);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($tipocontrato),1,0,'C');
            }
            if($ingreso!="A"){
                $lng = strlen($producto->numerocontrato);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($producto->numerocontrato),1,0,'C');
            }
            if(!$proveedor>0){
                $lng = strlen($producto->razon);
                $wdt = $multiplo*($ancho/$lng);
                Fpdf::SetFont('Arial','',min([8,$wdt]));
                Fpdf::Cell($ancho,$espacio,utf8_decode($producto->razon),1,0,'C');
            }
            $lng = strlen($producto->serie);
            $wdt = $multiplo*(30/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell(30,$espacio,utf8_decode($producto->serie),1,0,'C');
            Fpdf::Cell(7,$espacio,"",1,0,'C');
        }
        Fpdf::Output();
        exit;
    }
    
    public function scopeReporteProductos($query,$productos) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SISGIEC");
        $objPHPExcel->getProperties()->setLastModifiedBy("SISGIEC");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Reporte de productos generado por sistema SISGIEC.");
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->setCellValue("A1", "TIPO SUCURSAL");
        $sheet->setCellValue("C1", "SUCURSAL");
        $sheet->setCellValue("B1", "ÁREA");
        $sheet->setCellValue("D1", "TIPO EQUIPO");
        $sheet->setCellValue("E1", "MARCA");
        $sheet->setCellValue("F1", "MODELO");
        $sheet->setCellValue("G1", "INGRESO");
        $sheet->setCellValue("H1", "CONTRATO");
        $sheet->setCellValue("I1", "PROVEEDOR");
        $sheet->setCellValue("J1", "SERIE");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:J1')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB("8bc34a");
        
        $w=2;
        foreach ($productos as $producto) {
            $sheet->setCellValueExplicit("A".$w,$producto->nombretiposucursal ,  PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C".$w,$producto->nombresucursal ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B".$w,$producto->nombrearea,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D".$w,$producto->nombretipoequipo ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E".$w,$producto->nombremarca ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("F".$w,$producto->nombremodelo,PHPExcel_Cell_DataType::TYPE_STRING);
            if($producto->tipocontrato=="C"){
                $sheet->setCellValueExplicit("G".$w,"CONTRATO",PHPExcel_Cell_DataType::TYPE_STRING);
            }else{
                $sheet->setCellValueExplicit("G".$w,"ADQUISICIÓN",PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $sheet->setCellValueExplicit("H".$w,$producto->numerocontrato,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("I".$w,$producto->razon,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J".$w,$producto->serie,PHPExcel_Cell_DataType::TYPE_STRING);
            $w++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('PRODUCTOS');
        $objPHPExcel->setActiveSheetIndex(0);
        
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="PRODUCTOS.xls"');
        header("Cache-Control: max-age=0");


        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function scopeReporteContratos($query,$contratos) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SISGIEC");
        $objPHPExcel->getProperties()->setLastModifiedBy("SISGIEC");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Reporte de contratos generado por sistema SISGIEC.");
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->setCellValue("A1", "TIPO");
        $sheet->setCellValue("B1", "PROVEEDOR");
        $sheet->setCellValue("C1", "CONTRATO");
        $sheet->setCellValue("D1", "FECHA FIRMA");
        $sheet->setCellValue("E1", "INICIO");
        $sheet->setCellValue("F1", "FIN");
        $sheet->setCellValue("G1", "DESCRIPCION");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB("8bc34a");
        
        $w=2;
        foreach ($contratos as $contrato) {
            if($contrato->tipo=="C"){
                $sheet->setCellValueExplicit("A".$w,"CONTRATO",PHPExcel_Cell_DataType::TYPE_STRING);
            }else{
                $sheet->setCellValueExplicit("A".$w,"ADQUISICIÓN",PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $sheet->setCellValueExplicit("B".$w,$contrato->razon,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C".$w,$contrato->numero ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D".$w,date('d/m/Y',strtotime($contrato->fecha)),PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E".$w,date('d/m/Y',strtotime($contrato->inicio)) ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("F".$w,date('d/m/Y',strtotime($contrato->fin)) ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("G".$w,$contrato->descripcion,PHPExcel_Cell_DataType::TYPE_STRING);
            $w++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('CONTRATOS');
        $objPHPExcel->setActiveSheetIndex(0);
        
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="CONTRATOS.xls"');
        header("Cache-Control: max-age=0");


        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function scopeReporteCasos($query,$casos) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SISGIEC");
        $objPHPExcel->getProperties()->setLastModifiedBy("SISGIEC");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Reporte de casos generado por sistema SISGIEC.");
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->setCellValue("A1", "CASO");
        $sheet->setCellValue("B1", "ESTADO");
        $sheet->setCellValue("C1", "SERIE");
        $sheet->setCellValue("D1", "TÉCNICO");
        $sheet->setCellValue("E1", "TIPO CASO");
        $sheet->setCellValue("F1", "TIPO SOLUCIÓN");
        $sheet->setCellValue("G1", "TIPO EQUIPO");
        $sheet->setCellValue("H1", "MARCA");
        $sheet->setCellValue("I1", "MODELO");
        $sheet->setCellValue("J1", "CONTRATO");
        $sheet->setCellValue("K1", "PROVEEDOR");
        $sheet->setCellValue("L1", "TIPO SUCURSAL");
        $sheet->setCellValue("M1", "TIPO TERRITORIO");
        $sheet->setCellValue("N1", "SUCURSAL");
        $sheet->setCellValue("O1", "SLA");
        $sheet->setCellValue("P1", "FECHA INICIO");
        $sheet->setCellValue("Q1", "FECHA TÉCNICO");
        $sheet->setCellValue("R1", "FECHA DIAGNOSTICO");
        $sheet->setCellValue("S1", "FECHA TRÁNSITO");
        $sheet->setCellValue("T1", "FECHA FINALIZACIÓN");
        $sheet->setCellValue("U1", "PROBLEMA");
        $sheet->setCellValue("V1", "ANALISIS");
        $sheet->setCellValue("W1", "CONCLUSION");
        $sheet->setCellValue("X1", "COMENTARIO");
        
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('T1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('U1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('V1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('W1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('X1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:X1')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB("8bc34a");
        
        $w=2;
        foreach ($casos as $caso) {
            $sheet->setCellValueExplicit("A".$w,$caso->numero,PHPExcel_Cell_DataType::TYPE_STRING);
            if($caso->estado=="N"){
                $sheet->setCellValueExplicit("B".$w,"PENDIENTE",PHPExcel_Cell_DataType::TYPE_STRING);
            }else if($caso->estado=="T"){
                $sheet->setCellValueExplicit("B".$w,"CON TÉCNICO ASIGNADO",PHPExcel_Cell_DataType::TYPE_STRING);
            }else if($caso->estado=="D"){
                $sheet->setCellValueExplicit("B".$w,"CON DIAGNOSTICO",PHPExcel_Cell_DataType::TYPE_STRING);
            }else if($caso->estado=="E"){
                $sheet->setCellValueExplicit("B".$w,"EN TRÁNSITO",PHPExcel_Cell_DataType::TYPE_STRING);
            }else if($caso->estado=="F"){
                $sheet->setCellValueExplicit("B".$w,"FINALIZADO",PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $sheet->setCellValueExplicit("C".$w,$caso->serie,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D".$w,$caso->apellidostecnico.' '.$caso->nombretecnico,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E".$w,$caso->nombretipocaso,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("F".$w,$caso->nombretiposolucion,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("G".$w,$caso->nombretipoequipo,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("H".$w,$caso->nombremarca,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("I".$w,$caso->nombremodelo,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J".$w,$caso->numerocontrato,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("K".$w,$caso->razon,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("L".$w,$caso->nombretiposucursal,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("M".$w,$caso->nombretipoterritorio,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("N".$w,$caso->nombresucursal,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("O".$w,$caso->sla,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("P".$w,date('d/m/Y H:i',strtotime($caso->fecha)),PHPExcel_Cell_DataType::TYPE_STRING);
            if($caso->fechat!=null){
                $sheet->setCellValueExplicit("Q".$w,date('d/m/Y H:i',strtotime($caso->fechat)),PHPExcel_Cell_DataType::TYPE_STRING);
            }else{
                $sheet->setCellValueExplicit("Q".$w,null,PHPExcel_Cell_DataType::TYPE_STRING);
            }
            
            if($caso->fechad!=null){
                $sheet->setCellValueExplicit("R".$w,date('d/m/Y H:i',strtotime($caso->fechad)),PHPExcel_Cell_DataType::TYPE_STRING);
            }else{
                $sheet->setCellValueExplicit("R".$w,null,PHPExcel_Cell_DataType::TYPE_STRING);
            }
            
            if($caso->fechae!=null){
                $sheet->setCellValueExplicit("S".$w,date('d/m/Y H:i',strtotime($caso->fechae)),PHPExcel_Cell_DataType::TYPE_STRING);
            }else{
                $sheet->setCellValueExplicit("S".$w,null,PHPExcel_Cell_DataType::TYPE_STRING);
            }
            
            if($caso->fechaf!=null){
                $sheet->setCellValueExplicit("T".$w,date('d/m/Y H:i',strtotime($caso->fechaf)),PHPExcel_Cell_DataType::TYPE_STRING);
            }else{
                $sheet->setCellValueExplicit("T".$w,null,PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $sheet->setCellValueExplicit("U".$w,$caso->problema,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("V".$w,$caso->analisis,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("W".$w,$caso->conclusion,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("X".$w,$caso->comentario,PHPExcel_Cell_DataType::TYPE_STRING);
            $w++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('CASOS');
        $objPHPExcel->setActiveSheetIndex(0);
        
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="CASOS.xls"');
        header("Cache-Control: max-age=0");


        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function scopeReporteTraslados($query,$traslados) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SISGIEC");
        $objPHPExcel->getProperties()->setLastModifiedBy("SISGIEC");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Reporte de traslados generado por sistema SISGIEC.");
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->setCellValue("A1", "TRASLADO");
        $sheet->setCellValue("B1", "GUIA DE REMISIÓN");
        $sheet->setCellValue("C1", "FECHA");
        $sheet->setCellValue("D1", "DESCRIPCION");
        $sheet->setCellValue("E1", "ORIGEN");
        $sheet->setCellValue("F1", "DESTINO");
        $sheet->setCellValue("G1", "MOTIVO");
        
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB("8bc34a");
        
        $w=2;
        foreach ($traslados as $traslado) {
            $sheet->setCellValueExplicit("A".$w,$traslado->numero,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B".$w,$traslado->remision,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C".$w,date('d/m/Y',strtotime($traslado->fecha)),PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D".$w,$traslado->descripcion,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E".$w,$traslado->nombresucursal,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("F".$w,$traslado->sucursalrecibe()->nombre,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("G".$w,$traslado->nombremotivotraslado,PHPExcel_Cell_DataType::TYPE_STRING);
            $w++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('TRASLADOS');
        $objPHPExcel->setActiveSheetIndex(0);
        
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="TRASLADOS.xls"');
        header("Cache-Control: max-age=0");


        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function scopeReporteContratoPDF($query,$contrato,$productos) {
        Fpdf::AddPage('L','A4');
        
        $borde = 0;
        $espacio = 5;
        $restante = 232;
        $filtros = 6;
        $filas = 34;
        $multiplo = 4.2;
        $hoja = 2;
        
        Fpdf::SetAutoPageBreak(true,1);  
        
        Fpdf::SetFont('Arial','B',12);
        $x=8;
        $y=10;
        Fpdf::SetXY($x,$y);
        Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS DE CONTRATO '.$contrato->numero.' - HOJA 1'),$borde,0,'C');
        
        Fpdf::SetXY($x,$y=$y+10);
        Fpdf::SetFont('Arial','B',10);
        
        $ancho = $restante/$filtros;
        
        Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO SUC.'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('SUCURSAL'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('ÁREA'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
        Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
        
        $cant =0;
                
        foreach ($productos as $producto) {
            $cant = $cant +1;
            if($cant%$filas==0){
                Fpdf::AddPage('L','A4');
                Fpdf::SetFont('Arial','B',12);
                $x=8;
                $y=10;
                Fpdf::SetXY($x,$y);
                Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS DE CONTRATO '.$contrato->numero.' - HOJA '.$hoja++),$borde,0,'C');

                Fpdf::SetXY($x,$y=$y+10);
                Fpdf::SetFont('Arial','B',10);
                
                Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO SUC.'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('SUCURSAL'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('ÁREA'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
                Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
            }
            Fpdf::SetXY($x,$y=$y+$espacio);
            
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(10,$espacio,utf8_decode($cant),1,0,'C');
            
            if($producto->nombretiposucursal==null){
                $producto->nombretiposucursal = "DADO DE BAJA";
            }
            $lng = strlen($producto->nombretiposucursal);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombretiposucursal),1,0,'C');

            if($producto->nombresucursal==null){
                $producto->nombresucursal = "DADO DE BAJA";
            }
            $lng = strlen($producto->nombresucursal);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombresucursal),1,0,'C');

            if($producto->nombrearea==null){
                $producto->nombrearea = "SIN ÁREA";
            }
            $lng = strlen($producto->nombrearea);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombrearea),1,0,'C');

            $lng = strlen($producto->nombretipoequipo);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombretipoequipo),1,0,'C');

            $lng = strlen($producto->nombremarca);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremarca),1,0,'C');

            $lng = strlen($producto->nombremodelo);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremodelo),1,0,'C');
            
            $lng = strlen($producto->serie);
            $wdt = $multiplo*(30/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell(30,$espacio,utf8_decode($producto->serie),1,0,'C');
            Fpdf::Cell(7,$espacio,"",1,0,'C');
        }
        Fpdf::Output();
        exit;
    }
    
    public function scopeReporteContrato($query,$contrato,$productos) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SISGIEC");
        $objPHPExcel->getProperties()->setLastModifiedBy("SISGIEC");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Reporte de productos de contrato ".$contrato->numero." generado por sistema SISGIEC.");
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->setCellValue("A1", "TIPO SUCURSAL");
        $sheet->setCellValue("C1", "SUCURSAL");
        $sheet->setCellValue("B1", "ÁREA");
        $sheet->setCellValue("D1", "TIPO EQUIPO");
        $sheet->setCellValue("E1", "MARCA");
        $sheet->setCellValue("F1", "MODELO");
        $sheet->setCellValue("G1", "SERIE");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB("8bc34a");
        
        $w=2;
        foreach ($productos as $producto) {
            $sheet->setCellValueExplicit("A".$w,$producto->nombretiposucursal ,  PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C".$w,$producto->nombresucursal ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B".$w,$producto->nombrearea,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D".$w,$producto->nombretipoequipo ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E".$w,$producto->nombremarca ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("F".$w,$producto->nombremodelo,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("G".$w,$producto->serie,PHPExcel_Cell_DataType::TYPE_STRING);
            $w++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('PRODUCTOS');
        $objPHPExcel->setActiveSheetIndex(0);
        
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="CONTRATO'.$contrato->numero.'.xls"');
        header("Cache-Control: max-age=0");


        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function scopeReporteGuiaPDF($query,$guia,$productos) {
        Fpdf::AddPage('L','A4');
        
        $borde = 0;
        $espacio = 5;
        $restante = 232;
        $filtros = 6;
        $filas = 34;
        $multiplo = 4.2;
        $hoja = 2;
        
        Fpdf::SetAutoPageBreak(true,1);  
        
        Fpdf::SetFont('Arial','B',12);
        $x=8;
        $y=10;
        Fpdf::SetXY($x,$y);
        Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS DE GUIA '.$guia->numero.' - HOJA 1'),$borde,0,'C');
        
        Fpdf::SetXY($x,$y=$y+10);
        Fpdf::SetFont('Arial','B',10);
        
        $ancho = $restante/$filtros;
        
        Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO SUC.'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('SUCURSAL'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('ÁREA'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
        Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
        
        $cant =0;
                
        foreach ($productos as $producto) {
            $cant = $cant +1;
            if($cant%$filas==0){
                Fpdf::AddPage('L','A4');
                Fpdf::SetFont('Arial','B',12);
                $x=8;
                $y=10;
                Fpdf::SetXY($x,$y);
                Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS DE GUIA '.$guia->numero.' - HOJA '.$hoja++),$borde,0,'C');

                Fpdf::SetXY($x,$y=$y+10);
                Fpdf::SetFont('Arial','B',10);
                
                Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO SUC.'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('SUCURSAL'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('ÁREA'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
                Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
            }
            Fpdf::SetXY($x,$y=$y+$espacio);
            
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(10,$espacio,utf8_decode($cant),1,0,'C');
            
            if($producto->nombretiposucursal==null){
                $producto->nombretiposucursal = "DADO DE BAJA";
            }
            
            $lng = strlen($producto->nombretiposucursal);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombretiposucursal),1,0,'C');

            if($producto->nombresucursal==null){
                $producto->nombresucursal = "DADO DE BAJA";
            }
            $lng = strlen($producto->nombresucursal);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombresucursal),1,0,'C');

            if($producto->nombrearea==null){
                $producto->nombrearea = "SIN ÁREA";
            }
            $lng = strlen($producto->nombrearea);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombrearea),1,0,'C');

            $lng = strlen($producto->nombretipoequipo);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombretipoequipo),1,0,'C');

            $lng = strlen($producto->nombremarca);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremarca),1,0,'C');

            $lng = strlen($producto->nombremodelo);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremodelo),1,0,'C');
            
            $lng = strlen($producto->serie);
            $wdt = $multiplo*(30/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell(30,$espacio,utf8_decode($producto->serie),1,0,'C');
            Fpdf::Cell(7,$espacio,"",1,0,'C');
        }
        Fpdf::Output();
        exit;
    }
    
    public function scopeReporteGuia($query,$guia,$productos) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SISGIEC");
        $objPHPExcel->getProperties()->setLastModifiedBy("SISGIEC");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Reporte de productos de guia ".$guia->numero." generado por sistema SISGIEC.");
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->setCellValue("A1", "TIPO SUCURSAL");
        $sheet->setCellValue("C1", "SUCURSAL");
        $sheet->setCellValue("B1", "ÁREA");
        $sheet->setCellValue("D1", "TIPO EQUIPO");
        $sheet->setCellValue("E1", "MARCA");
        $sheet->setCellValue("F1", "MODELO");
        $sheet->setCellValue("G1", "SERIE");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:G1')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB("8bc34a");
        
        $w=2;
        foreach ($productos as $producto) {
            $sheet->setCellValueExplicit("A".$w,$producto->nombretiposucursal ,  PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C".$w,$producto->nombresucursal ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B".$w,$producto->nombrearea,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D".$w,$producto->nombretipoequipo ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("E".$w,$producto->nombremarca ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("F".$w,$producto->nombremodelo,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("G".$w,$producto->serie,PHPExcel_Cell_DataType::TYPE_STRING);
            $w++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('PRODUCTOS');
        $objPHPExcel->setActiveSheetIndex(0);
        
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="GUIA'.$guia->numero.'.xls"');
        header("Cache-Control: max-age=0");


        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function scopeReporteTrasladoPDF($query,$traslado,$productos) {
        Fpdf::AddPage('L','A4');
        
        $borde = 0;
        $espacio = 5;
        $restante = 232;
        $filtros = 3;
        $filas = 34;
        $multiplo = 4.2;
        $hoja = 2;
        
        Fpdf::SetAutoPageBreak(true,1);  
        
        Fpdf::SetFont('Arial','B',12);
        $x=8;
        $y=10;
        Fpdf::SetXY($x,$y);
        Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS DE TRASLADO '.$traslado->numero.' - HOJA 1'),$borde,0,'C');
        
        Fpdf::SetXY($x,$y=$y+10);
        Fpdf::SetFont('Arial','B',10);
        
        $ancho = $restante/$filtros;
        
        Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
        Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
        
        $cant =0;
                
        foreach ($productos as $producto) {
            $cant = $cant +1;
            if($cant%$filas==0){
                Fpdf::AddPage('L','A4');
                Fpdf::SetFont('Arial','B',12);
                $x=8;
                $y=10;
                Fpdf::SetXY($x,$y);
                Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS DE TRASLADO '.$traslado->numero.' - HOJA '.$hoja++),$borde,0,'C');

                Fpdf::SetXY($x,$y=$y+10);
                Fpdf::SetFont('Arial','B',10);
                
                Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
                
                Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
                Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
            }
            Fpdf::SetXY($x,$y=$y+$espacio);
            
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(10,$espacio,utf8_decode($cant),1,0,'C');
            
            $lng = strlen($producto->nombretipoequipo);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombretipoequipo),1,0,'C');

            $lng = strlen($producto->nombremarca);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremarca),1,0,'C');

            $lng = strlen($producto->nombremodelo);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremodelo),1,0,'C');
            
            $lng = strlen($producto->serie);
            $wdt = $multiplo*(30/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell(30,$espacio,utf8_decode($producto->serie),1,0,'C');
            Fpdf::Cell(7,$espacio,"",1,0,'C');
        }
        Fpdf::Output();
        exit;
    }
    
    public function scopeReporteTraslado($query,$traslado,$productos) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SISGIEC");
        $objPHPExcel->getProperties()->setLastModifiedBy("SISGIEC");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Reporte de productos de traslado ".$traslado->numero." generado por sistema SISGIEC.");
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->setCellValue("A1", "TIPO EQUIPO");
        $sheet->setCellValue("B1", "MARCA");
        $sheet->setCellValue("C1", "MODELO");
        $sheet->setCellValue("D1", "SERIE");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:D1')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB("8bc34a");
        
        $w=2;
        foreach ($productos as $producto) {
            $sheet->setCellValueExplicit("A".$w,$producto->nombretipoequipo ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B".$w,$producto->nombremarca ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C".$w,$producto->nombremodelo,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D".$w,$producto->serie,PHPExcel_Cell_DataType::TYPE_STRING);
            $w++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('PRODUCTOS');
        $objPHPExcel->setActiveSheetIndex(0);
        
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="TRASLADO'.$traslado->numero.'.xls"');
        header("Cache-Control: max-age=0");


        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    
    public function scopeReporteBajaPDF($query,$baja,$productos) {
        Fpdf::AddPage('L','A4');
        
        $borde = 0;
        $espacio = 5;
        $restante = 232;
        $filtros = 3;
        $filas = 34;
        $multiplo = 4.2;
        $hoja = 2;
        
        Fpdf::SetAutoPageBreak(true,1);  
        
        Fpdf::SetFont('Arial','B',12);
        $x=8;
        $y=10;
        Fpdf::SetXY($x,$y);
        Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS DE GUIA DE BAJA '.$baja->numero.' - HOJA 1'),$borde,0,'C');
        
        Fpdf::SetXY($x,$y=$y+10);
        Fpdf::SetFont('Arial','B',10);
        
        $ancho = $restante/$filtros;
        
        Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
        Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
        Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
        
        $cant =0;
                
        foreach ($productos as $producto) {
            $cant = $cant +1;
            if($cant%$filas==0){
                Fpdf::AddPage('L','A4');
                Fpdf::SetFont('Arial','B',12);
                $x=8;
                $y=10;
                Fpdf::SetXY($x,$y);
                Fpdf::Cell(280,10,utf8_decode('REPORTE DE PRODUCTOS DE GUIA DE BAJA '.$baja->numero.' - HOJA '.$hoja++),$borde,0,'C');

                Fpdf::SetXY($x,$y=$y+10);
                Fpdf::SetFont('Arial','B',10);
                
                Fpdf::Cell(10,$espacio,utf8_decode('N°'),1,0,'C');
                
                Fpdf::Cell($ancho,$espacio,utf8_decode('TIPO EQU.'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('MARCA'),1,0,'C');
                Fpdf::Cell($ancho,$espacio,utf8_decode('MODELO'),1,0,'C');
                Fpdf::Cell(30,$espacio,utf8_decode('SERIE'),1,0,'C');
            }
            Fpdf::SetXY($x,$y=$y+$espacio);
            
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(10,$espacio,utf8_decode($cant),1,0,'C');
            
            $lng = strlen($producto->nombretipoequipo);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombretipoequipo),1,0,'C');

            $lng = strlen($producto->nombremarca);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremarca),1,0,'C');

            $lng = strlen($producto->nombremodelo);
            $wdt = $multiplo*($ancho/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell($ancho,$espacio,utf8_decode($producto->nombremodelo),1,0,'C');
            
            $lng = strlen($producto->serie);
            $wdt = $multiplo*(30/$lng);
            Fpdf::SetFont('Arial','',min([8,$wdt]));
            Fpdf::Cell(30,$espacio,utf8_decode($producto->serie),1,0,'C');
            Fpdf::Cell(7,$espacio,"",1,0,'C');
        }
        Fpdf::Output();
        exit;
    }
    
    public function scopeReporteBaja($query,$baja,$productos) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SISGIEC");
        $objPHPExcel->getProperties()->setLastModifiedBy("SISGIEC");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Reporte de productos de guia de baja ".$baja->numero." generado por sistema SISGIEC.");
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $sheet->setCellValue("A1", "TIPO EQUIPO");
        $sheet->setCellValue("B1", "MARCA");
        $sheet->setCellValue("C1", "MODELO");
        $sheet->setCellValue("D1", "SERIE");
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:D1')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB("8bc34a");
        
        $w=2;
        foreach ($productos as $producto) {
            $sheet->setCellValueExplicit("A".$w,$producto->nombretipoequipo ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B".$w,$producto->nombremarca ,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C".$w,$producto->nombremodelo,PHPExcel_Cell_DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D".$w,$producto->serie,PHPExcel_Cell_DataType::TYPE_STRING);
            $w++;
        }
        $objPHPExcel->getActiveSheet()->setTitle('PRODUCTOS');
        $objPHPExcel->setActiveSheetIndex(0);
        
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment;filename="GUIADEBAJA'.$baja->numero.'.xls"');
        header("Cache-Control: max-age=0");


        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}
    