<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rembourssement extends Model
{
    use HasFactory;

    protected $guarded = [''];


    public function client()
    {
        //relation pour dire qu'un employé à au moin un departement
        return $this->belongsTo(Client::class);
    }

    public function facture()
{
    return $this->belongsTo(Facture::class, 'facture_id');
}

}
