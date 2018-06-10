<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Anouar\Fpdf\Facades\Fpdf;
use App\Traslado;
use Datetime;
use App\NumeroTexto;
class Reportes extends Model
{
    public function scopeCuotasPendientes($query,$cuotas,$desde,$hasta) {
        Fpdf::AddPage();
        $x=10;
        $y=10;
        $borde = 0;
        Fpdf::SetAutoPageBreak(true,1);  
        Fpdf::SetFont('Arial','B',12);
        Fpdf::SetXY($x,$y);
        Fpdf::Cell(190,10,utf8_decode('REPORTE DE CUOTAS PENDIENTES'),$borde,0,'C');
        if(!empty($desde)){
            $desde = date('d/m/Y',strtotime($desde));
            Fpdf::SetXY($x,$y=$y+5);
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(190,10,utf8_decode("DESDE: ".$desde),$borde,0,'L');
        }
        if(!empty($hasta)){
            $hasta = date('d/m/Y',strtotime($hasta));
            Fpdf::SetXY($x,$y=$y+5);
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(190,10,utf8_decode("HASTA: ".$hasta),$borde,0,'L');
        }
        Fpdf::SetXY($x,$y=$y+10);
        Fpdf::SetFont('Arial','B',10);
        Fpdf::Cell(10,5,utf8_decode('N°'),1,0,'C');
        Fpdf::Cell(50,5,utf8_decode('CLIENTE'),1,0,'C');
        Fpdf::Cell(30,5,utf8_decode('DETALLE'),1,0,'C');
        Fpdf::Cell(20,5,utf8_decode('FECHA'),1,0,'C');
        Fpdf::Cell(25,5,utf8_decode('MONTO'),1,0,'C');
        Fpdf::Cell(25,5,utf8_decode('PAGADO'),1,0,'C');
        Fpdf::Cell(25,5,utf8_decode('PENDIENTE'),1,0,'C');
        $espacio = 5;
        Fpdf::SetFont('Arial','',8);
        $cant =0;
        $total = 0.0;
        foreach ($cuotas as $cuota) {
            $cant = $cant +1;
            if($cant%45==0){
                Fpdf::AddPage();
                $x=10;
                $y=10;
                Fpdf::SetXY($x,$y=$y+10);
                Fpdf::SetFont('Arial','',8);
            }
            Fpdf::SetXY($x,$y=$y+$espacio);
            Fpdf::Cell(10,$espacio,utf8_decode($cant),1,0,'C');
            Fpdf::Cell(50,$espacio,utf8_decode($cuota->proyecto->usuario->nombres." ".$cuota->proyecto->usuario->paterno." ".$cuota->proyecto->usuario->materno),1,0,'L');
            Fpdf::Cell(30,$espacio,utf8_decode($cuota->detalle),1,0,'L');
            $fecha = date('d/m/Y',strtotime($cuota->fecha));
            Fpdf::Cell(20,$espacio,utf8_decode($fecha),1,0,'C');
            Fpdf::Cell(25,$espacio,utf8_decode($cuota->monto),1,0,'C');
            Fpdf::Cell(25,$espacio,utf8_decode(((empty($cuota->pagos)?"0.00": $cuota->pagos))),1,0,'C');
            $debe = 0;
            if($cuota->pagos>0){
                $debe = $cuota->monto-$cuota->pagos;
            }else{
                $debe = $cuota->monto;
            }
            Fpdf::Cell(25,$espacio,utf8_decode($debe),1,0,'C');
            $total += $debe;
        }
        Fpdf::SetXY($x+10+50+30+20+25,$y=$y+$espacio);
        Fpdf::Cell(25,$espacio,utf8_decode("TOTAL"),1,0,'L');
        Fpdf::Cell(25,$espacio,utf8_decode("S/ ".round($total,2)),1,0,'C');
        Fpdf::Output();
        exit;
    }


    public function scopePagosRealizados($query,$pagos,$desde,$hasta) {
        Fpdf::AddPage();
        $x=10;
        $y=10;
        $borde = 0;
        Fpdf::SetAutoPageBreak(true,1);  
        Fpdf::SetFont('Arial','B',12);
        Fpdf::SetXY($x,$y);
        Fpdf::Cell(190,10,utf8_decode('REPORTE DE PAGOS REALIZADOS'),$borde,0,'C');
        if(!empty($desde)){
            $desde = date('d/m/Y',strtotime($desde));
            Fpdf::SetXY($x,$y=$y+5);
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(190,10,utf8_decode("DESDE: ".$desde),$borde,0,'L');
        }
        if(!empty($hasta)){
            $hasta = date('d/m/Y',strtotime($hasta));
            Fpdf::SetXY($x,$y=$y+5);
            Fpdf::SetFont('Arial','',8);
            Fpdf::Cell(190,10,utf8_decode("HASTA: ".$hasta),$borde,0,'L');
        }
        Fpdf::SetXY($x,$y=$y+10);
        Fpdf::SetFont('Arial','B',10);
        Fpdf::Cell(10,5,utf8_decode('N°'),1,0,'C');
        Fpdf::Cell(105,5,utf8_decode('CLIENTE'),1,0,'C');
        Fpdf::Cell(20,5,utf8_decode('FECHA'),1,0,'C');
        Fpdf::Cell(25,5,utf8_decode('N° RECIBO'),1,0,'C');
        Fpdf::Cell(25,5,utf8_decode('MONTO'),1,0,'C');
        $espacio = 5;
        Fpdf::SetFont('Arial','',8);
        $cant =0;
        $total = 0.0;
        foreach ($pagos as $pago) {
            $cant = $cant +1;
            if($cant%45==0){
                Fpdf::AddPage();
                $x=10;
                $y=10;
                Fpdf::SetXY($x,$y=$y+10);
                Fpdf::SetFont('Arial','',8);
            }
            Fpdf::SetXY($x,$y=$y+$espacio);
            Fpdf::Cell(10,$espacio,utf8_decode($cant),1,0,'C');
            Fpdf::Cell(105,$espacio,utf8_decode($pago->cuota->proyecto->usuario->nombres." ".$pago->cuota->proyecto->usuario->paterno." ".$pago->cuota->proyecto->usuario->materno),1,0,'L');
            $fecha = date('d/m/Y',strtotime($pago->fecha));
            Fpdf::Cell(20,$espacio,utf8_decode($fecha),1,0,'C');
            Fpdf::Cell(25,$espacio,utf8_decode($pago->operacion),1,0,'C');
            Fpdf::Cell(25,$espacio,utf8_decode($pago->monto),1,0,'C');
            $total += $pago->monto;
        }
        Fpdf::SetXY($x+10+50+30+20+25,$y=$y+$espacio);
        Fpdf::Cell(25,$espacio,utf8_decode("TOTAL"),1,0,'L');
        Fpdf::Cell(25,$espacio,utf8_decode("S/ ".round($total,2)),1,0,'C');
        Fpdf::Output();
        exit;
    }
    
}
