<?php

namespace App\Widgets;

use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;
use DB;

class FirstWidget extends BaseDimmer
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
        $users = Voyager::model('User')->count();

        $template = DB::table('templates')->where('assign', Auth::id())->count();

        $table = DB::table('templates')
                 ->rightJoin('verifications', 'templates.id', '=', 'verifications.template_id')
                 ->where('templates.assign', Auth::id())
                 ->count();

        // $infografis

        return view('vendor.voyager.widget.first', [
            'user'   => $users,
            'template' => $template,
            'tabel' => $table
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
        // return app('VoyagerAuth')->user()->can('browse', Voyager::model('User'));
    }
}
