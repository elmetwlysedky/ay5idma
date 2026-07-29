<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
    protected $table = 'oauth_access_tokens';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];
}
