<?php

namespace App\Exports;

use App\Services\PieceService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PiecesReportExport
{
    protected PieceService $pieceService;

    public function __construct(PieceService $pieceService)
    {
        $this->pieceService = $pieceService;
    }

    public function downloadPDF()
    {
        try {
            $pieces = $this->pieceService->getAllPieces();

            // Group pieces by project and then by block
            $piecesByProject = $pieces->groupBy(function ($piece) {
                return $piece->block->project->name;
            })->map(function ($projectPieces) {
                return $projectPieces->groupBy(function ($piece) {
                    return $piece->block->name;
                });
            });

            $data = [
                'piecesByProject' => $piecesByProject,
                'totalPieces' => $pieces->count(),
                'generatedDate' => now()->format('d/m/Y H:i:s'),
            ];

            $pdf = Pdf::loadView('reports.pieces', $data);

            // Set paper size and orientation
            $pdf->setPaper('A4', 'landscape');

            // Set PDF options for better rendering
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'Arial',
                'dpi' => 150
            ]);

            $filename = 'reporte_piezas_' . now()->format('Y-m-d_His') . '.pdf';

            // Generar PDF y guardar temporalmente
            $pdfContent = $pdf->output();

            // Guardar en storage/app/public/reports
            $reportPath = 'reports/' . $filename;
            Storage::disk('public')->put($reportPath, $pdfContent);

            // Retornar datos para descarga
            return [
                'success' => true,
                'download_url' => asset('storage/' . $reportPath),
                'filename' => $filename
            ];
        } catch (\Exception $e) {
            throw new \Exception('Error al generar el reporte PDF: ' . $e->getMessage());
        }
    }

    public function getReportData()
    {
        $pieces = $this->pieceService->getAllPieces();

        return [
            'pieces' => $pieces,
            'totalPieces' => $pieces->count(),
            'pendingPieces' => $pieces->filter(fn($p) => $p->status->value === 'pending')->count(),
            'manufacturedPieces' => $pieces->filter(fn($p) => $p->status->value === 'manufactured')->count(),
            'totalTheoreticalWeight' => $pieces->sum('theorical_weight'),
            'totalRealWeight' => $pieces->whereNotNull('real_weight')->sum('real_weight'),
        ];
    }
}
