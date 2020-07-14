<?php

namespace App\Widgets;

use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Widgets\BaseDimmer;
use DB;

class SecondWidget extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data = DB::table('templates')
                ->rightJoin('verifications', 'templates.id', '=', 'verifications.template_id')
                ->select(
                    'templates.name',
                    'verifications.year',
                    'verifications.created_at',
                    'verifications.check',
                    'verifications.status'
                )->where('templates.assign', Auth::id())
                ->take(5)
                ->orderBy('verifications.year', 'desc')
                ->get();

        return view('vendor.voyager.widget.second', [
            'data' => $data
        ]);
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return true;
    }
}
