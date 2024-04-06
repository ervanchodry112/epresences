<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EPresence extends Model
{
    use HasFactory;

    protected $table = 'epresence';

    protected $fillable = [
        'id_users',
        'type',
        'is_approve',
        'waktu',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_users', 'id');
    }

    public function createPresence()
    {
        DB::beginTransaction();

        try {
            $this->is_approve = false;
            $this->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function approvePresence(){
        DB::beginTransaction();

        try{
            $this->is_approve = true;
            $this->save();

            DB::commit();

        }catch(Exception $e){
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
