<?php

namespace App\Http\Resources;

use App\Models\EPresence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresenceResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $out = Epresence::whereDate('waktu', Carbon::parse($this->waktu)->toDateString())->where('type', 'OUT')->first();

        $res = [
            'id_user'       => $this->user->id,
            'nama_user'     => $this->user->nama,
            'tanggal'       => Carbon::parse($this->waktu)->format('Y-m-d'),
            'waktu_masuk'   => Carbon::parse($this->waktu)->toTimeString(),
            'status_masuk'  => $this->is_approve == true ? 'APPROVE' : 'REJECT',
        ];

        if (!empty($out)) {
            $res['waktu_pulang'] = Carbon::parse($out->waktu)->toTimeString();
            $res['status_pulang'] = $out->is_approve == true ? 'APPROVE' : 'REJECT';
        }else{
            $res['waktu_pulang'] = '-';
            $res['status_pulang'] = '-';
        }

        return $res;
    }
}
