<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $guarded = [''];


    public function client()
{
    return $this->belongsTo(Client::class, 'client_id');
}


    public function mode()
{
    return $this->belongsTo(ModePaiement::class, 'mode_id');
}


}
