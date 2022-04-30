<?php


namespace App\Repositories;


use App\Interfaces\ConsultationInterface;
use App\Models\Consultation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ConsultationRepository extends BaseRepository implements ConsultationInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
