<?php

namespace App\Http\Resources;

use App\Models\Trainer;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainerResource extends JsonResource
{

    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'name' => $this->user->name,
        'email' => $this->user->email,
        'has_dbs' => $this->has_dbs,
        'dbs_date' => $this->dbs_date ? $this->dbs_date : null,
        'dbs_renewal_date' => $this->dbs_renewal_date ? $this->dbs_renewal_date : null,
        'dbs_cert_path' => $this->dbs_cert_path ? $this->dbs_cert_path : null,
        'has_completed_madatory_training' => $this->has_completed_mandatory_training,
        'madatory_training_cert_5' => $this->mandatory_training_cert_5 ? $this->mandatory_training_cert_5 : null,
        'madatory_training_cert_4' => $this->mandatory_training_cert_4 ? $this->mandatory_training_cert_4 : null,
        'madatory_training_cert_3' => $this->mandatory_training_cert_3 ? $this->mandatory_training_cert_3 : null,
        'madatory_training_cert_2' => $this->mandatory_training_cert_2 ? $this->mandatory_training_cert_2 : null,
        'madatory_training_cert_1' => $this->mandatory_training_cert_1 ? $this->mandatory_training_cert_1 : null
       ];
    }
}
