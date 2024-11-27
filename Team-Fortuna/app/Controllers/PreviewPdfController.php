<?php

namespace App\Controllers;
use App\Models\Proposal_Model;

class PreviewPdfController extends BaseController
{

    public function previewPdf($data)
    {

            $proposalModel = new Proposal_Model();
            $proposal = $proposalModel->find($data);
            return view('preview_pdf', ['proposals' => $proposal]);
    }
}
