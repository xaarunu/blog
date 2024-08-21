<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GeneralObserver
{
    public function created(Model $model) {
        $this->crearLog($model, 'create');
    }

    public function updated(Model $model) {
        $this->crearLog($model, 'update');
    }

    public function deleted(Model $model) {
        $this->crearLog($model, 'delete');
    }

    private function crearLog(Model $model, $type) {
        if($user = auth()->user()) {
            if($type == 'create') $msg = "Registro creado: ";
            elseif($type == 'update') $msg = "Registro actualizado: ";
            elseif($type == 'delete') $msg = "Registro eliminado: ";
    
            Log::channel('user_activity')->info($msg . class_basename($model), [
                'user' => $user->rpe,
                'info' => $model->getAttributes()
            ]);
        }
    }
}
