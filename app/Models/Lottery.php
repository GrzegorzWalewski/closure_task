<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\LotteryTicket;

class Lottery extends Model
{
    use HasFactory;
    public function lottery_tickets($date)
    {
        return $this->hasMany(LotteryTicket::class)->where('created_at','>', $date);
    }
    public function handle(\Closure $tickets, $slug, $date = null)
    {
        $lottery = Lottery::where('slug', $slug)->get()->first();
        if($date == null)
        {
            $date = Carbon::now()->subDays(30);
        }

        return $tickets($lottery, $date);
    }
    public function executeFunction()
    {
        $slug = "example-slug";
        $date = Carbon::createFromFormat('Y-m-d', "2020-04-27");
        return $this->handle(function ($lottery, $date) {
            return $lottery->lottery_tickets($date)->get();
        }, $slug, $date);
    }
}
