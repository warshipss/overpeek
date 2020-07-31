<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Features\FaceitHooks;

class CallbackController extends Controller
{
    use FaceitHooks;

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function faceit(Request $request)
    {
        // TODO: Remove callback tracking
        app('log')->info($request->all());

        if (config('app.env') !== 'dev' && $request->header('X-FaceIT-Secret') !== config('services.faceit.webhook_secret')) {
            abort(403);
        }

        $event = Str::camel($request->get('event'));

        if (method_exists($this, $event)) {
            return $this->{$event}(json_decode(json_encode($request->get('payload'))));
        }

        return 'OK';
    }
}
