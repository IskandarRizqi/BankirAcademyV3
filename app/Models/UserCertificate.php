<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCertificate extends Model
{
    protected $table = 'user_certificates';
    protected $fillable = [
        'user_id',
        'certificate_template_id',
        'certificate_code',
        'issued_at'
    ];

    public function template()
    {
        return $this->belongsTo(CertificateTemplate::class, 'certificate_template_id');
    }
}