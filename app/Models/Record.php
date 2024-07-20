<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $customer_id
 * @property string $first_name
 * @property string $last_name
 * @property string $company
 * @property string $city
 * @property string $country
 * @property string $phone_1
 * @property string $phone_2
 * @property string $email
 * @property string $subscription_date
 * @property string $website
 */
class Record extends Model {
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'company',
        'city',
        'country',
        'phone_1',
        'phone_2',
        'email',
        'subscription_date',
        'website',
    ];

    protected $casts = [
        'subscription_date' => 'date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
