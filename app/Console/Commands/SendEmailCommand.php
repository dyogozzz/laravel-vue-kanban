<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Mail\TaskExpirationNotification;

class SendEmailCommand extends Command
{
    protected $signature = 'send:email';

    protected $description = 'Send email for upcoming tasks';

    public function handle()
    {
        $task = Task::find(6); // Exemplo: Obtendo uma tarefa específica do banco de dados

        // Verifique se a data de vencimento está próxima (por exemplo, dentro de 2 dias)
        $limite = $task->vencimento;
        $dataAtual = date('Y-m-d');
        $limiteLimite = date('Y-m-d', strtotime('+2 days', strtotime($dataAtual)));
        
        if ($limite <= $limiteLimite) {
            Mail::to('dyogozanetti@hotmail.com')
                ->send(new TaskExpirationNotification($task));
        }
        
        return 0;
    }
}
