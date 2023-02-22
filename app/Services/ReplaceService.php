<?php

namespace App\Services;

use App\Http\Requests\Api\ReplaceRequest;
use PhpOffice\PhpWord\TemplateProcessor;

class ReplaceService
{
    /**
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    public function replace(ReplaceRequest $request): string
    {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $filePath = public_path('uploads/'.$fileName);

        $templateProcessor = new TemplateProcessor($filePath);
        $templateProcessor->setValue($request->key, $request->text);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $saveDocPath = public_path('uploads/_'.$fileName);
        $templateProcessor->saveAs($saveDocPath);

        $Content = \PhpOffice\PhpWord\IOFactory::load($saveDocPath);

        $savePdfPath = public_path('uploads/result.pdf');

        if (file_exists($savePdfPath)) {
            unlink($savePdfPath);
        }

        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content, 'PDF');
        $PDFWriter->save($savePdfPath);

        if (file_exists($saveDocPath)) {
            unlink($saveDocPath);
        }

        return $savePdfPath;
    }
}
