<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
namespace App\Http\Controllers;
use App\Services\logService;
use Illuminate\Support\Facades\Log;

class logController extends Controller
{
    protected $logService;


    public function __construct(logService $logService)
    {
        $this->logService = $logService;
    }

    public function index()
    {
        try {
            $logs = $this->logService->listarLogs();
            //dd($logs);
            return view('log.index', compact('logs'));
        } catch (\Exception $e) {
            Log::error('Erro ao listar logs: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar as logs.');
        }
    }

}
